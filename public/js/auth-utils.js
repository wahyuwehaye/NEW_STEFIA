/**
 * Authentication and CSRF Utilities for STEFIA
 * Provides helper functions for handling authentication and CSRF tokens
 */

// CSRF Token Management
class CSRFManager {
    static getToken() {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) {
            console.warn('CSRF token not found in meta tag');
        }
        return token;
    }
    
    static setTokenHeader(headers = {}) {
        const token = this.getToken();
        if (token) {
            headers['X-CSRF-TOKEN'] = token;
        }
        headers['X-Requested-With'] = 'XMLHttpRequest';
        return headers;
    }
    
    static refreshToken() {
        return fetch('/csrf-token', {
            method: 'GET',
            headers: this.setTokenHeader()
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            }
            return data.token;
        })
        .catch(error => {
            console.error('Failed to refresh CSRF token:', error);
        });
    }
}

// Authentication Status Manager
class AuthManager {
    static checkStatus() {
        return fetch('/api/user', {
            method: 'GET',
            headers: CSRFManager.setTokenHeader({
                'Content-Type': 'application/json'
            })
        })
        .then(response => {
            if (response.status === 401) {
                return { authenticated: false };
            }
            return response.json().then(user => ({ authenticated: true, user }));
        })
        .catch(() => ({ authenticated: false }));
    }
    
    static logout(redirectUrl = '/login') {
        return fetch('/logout', {
            method: 'POST',
            headers: CSRFManager.setTokenHeader({
                'Content-Type': 'application/json'
            })
        })
        .then(() => {
            window.location.href = redirectUrl;
        })
        .catch(error => {
            console.error('Logout failed:', error);
            // Force redirect even if logout fails
            window.location.href = redirectUrl;
        });
    }
}

// Enhanced Fetch Wrapper with Authentication Handling
class AuthenticatedFetch {
    static async request(url, options = {}) {
        // Set default options
        const defaultOptions = {
            headers: CSRFManager.setTokenHeader({
                'Content-Type': 'application/json',
                ...options.headers
            }),
            credentials: 'same-origin'
        };
        
        const finalOptions = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(url, finalOptions);
            
            // Handle authentication errors
            if (response.status === 401) {
                this.handleAuthError();
                throw new Error('Authentication required');
            }
            
            // Handle CSRF token mismatch
            if (response.status === 419) {
                await CSRFManager.refreshToken();
                // Retry the request with new token
                finalOptions.headers = CSRFManager.setTokenHeader(options.headers || {});
                const retryResponse = await fetch(url, finalOptions);
                
                if (retryResponse.status === 401) {
                    this.handleAuthError();
                    throw new Error('Authentication required');
                }
                
                return retryResponse;
            }
            
            return response;
            
        } catch (error) {
            if (error.message === 'Authentication required') {
                this.handleAuthError();
            }
            throw error;
        }
    }
    
    static handleAuthError() {
        // Show authentication error message
        if (typeof showErrorToast === 'function') {
            showErrorToast('Session Anda telah habis. Mengarahkan ke halaman login...');
        }
        
        // Redirect to login after a short delay
        setTimeout(() => {
            window.location.href = '/login?expired=1';
        }, 2000);
    }
    
    static async get(url, options = {}) {
        return this.request(url, { ...options, method: 'GET' });
    }
    
    static async post(url, data, options = {}) {
        return this.request(url, {
            ...options,
            method: 'POST',
            body: JSON.stringify(data)
        });
    }
    
    static async put(url, data, options = {}) {
        return this.request(url, {
            ...options,
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }
    
    static async delete(url, options = {}) {
        return this.request(url, { ...options, method: 'DELETE' });
    }
}

// Form Submission Helper with Authentication
class AuthenticatedForm {
    static setupForm(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) {
            console.warn(`Form with selector "${formSelector}" not found`);
            return;
        }
        
        form.addEventListener('submit', this.handleSubmit.bind(this));
    }
    
    static async handleSubmit(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const url = form.action || window.location.href;
        const method = form.method || 'POST';
        
        // Convert FormData to JSON
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        
        try {
            const response = await AuthenticatedFetch.request(url, {
                method: method.toUpperCase(),
                body: JSON.stringify(data)
            });
            
            if (response.ok) {
                const result = await response.json();
                this.handleSuccess(result, form);
            } else {
                const error = await response.json();
                this.handleError(error, form);
            }
            
        } catch (error) {
            console.error('Form submission failed:', error);
            this.handleError({ message: 'Terjadi kesalahan saat mengirim form.' }, form);
        }
    }
    
    static handleSuccess(result, form) {
        if (typeof showSuccessToast === 'function') {
            showSuccessToast(result.message || 'Berhasil menyimpan data');
        }
        
        // Redirect if specified
        if (result.redirect) {
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 1500);
        }
        
        // Reset form if needed
        if (result.reset_form) {
            form.reset();
        }
    }
    
    static handleError(error, form) {
        if (typeof showErrorToast === 'function') {
            showErrorToast(error.message || 'Terjadi kesalahan');
        }
        
        // Display field-specific errors
        if (error.errors) {
            Object.keys(error.errors).forEach(field => {
                const fieldElement = form.querySelector(`[name="${field}"]`);
                if (fieldElement) {
                    this.showFieldError(fieldElement, error.errors[field][0]);
                }
            });
        }
    }
    
    static showFieldError(fieldElement, message) {
        // Remove existing error message
        const existingError = fieldElement.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-danger mt-1';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.textContent = message;
        
        fieldElement.parentNode.appendChild(errorDiv);
        
        // Add error styling to field
        fieldElement.classList.add('is-invalid');
        
        // Remove error when field is modified
        fieldElement.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const error = this.parentNode.querySelector('.field-error');
            if (error) {
                error.remove();
            }
        }, { once: true });
    }
}

// Global availability
window.CSRFManager = CSRFManager;
window.AuthManager = AuthManager;
window.AuthenticatedFetch = AuthenticatedFetch;
window.AuthenticatedForm = AuthenticatedForm;

// Auto-initialize
document.addEventListener('DOMContentLoaded', function() {
    // Setup common forms
    const forms = document.querySelectorAll('form[data-auth-form]');
    forms.forEach(form => {
        AuthenticatedForm.setupForm(`#${form.id}` || form);
    });
    
    console.log('Authentication utilities initialized');
});
