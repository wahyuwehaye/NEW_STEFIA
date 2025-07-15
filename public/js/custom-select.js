/**
 * Modern Select Dropdown JavaScript Enhancements
 * Provides enhanced functionality for select dropdowns
 */

(function($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function() {
        initializeCustomSelects();
        initializeSelect2();
        handleSelectEvents();
    });

    /**
     * Initialize custom select styling
     */
    function initializeCustomSelects() {
        // Add custom classes to existing selects
        $('select').each(function() {
            var $select = $(this);
            
            // Add custom styling classes if not already present
            if (!$select.hasClass('js-select2')) {
                $select.addClass('custom-select-enhanced');
            }
            
            // Add keyboard navigation support
            $select.on('keydown', function(e) {
                handleKeyNavigation(e, $select);
            });
        });
    }

    /**
     * Initialize Select2 with custom configuration
     */
    function initializeSelect2() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('.js-select2').each(function() {
                var $select = $(this);
                var placeholder = $select.attr('placeholder') || 'Pilih opsi...';
                var allowClear = $select.data('allow-clear') !== false;
                
                $select.select2({
                    placeholder: placeholder,
                    allowClear: allowClear,
                    width: '100%',
                    theme: 'bootstrap-5',
                    dropdownParent: $select.closest('.modal').length ? $select.closest('.modal') : $(document.body),
                    language: {
                        noResults: function() {
                            return "Tidak ada hasil yang ditemukan";
                        },
                        searching: function() {
                            return "Mencari...";
                        },
                        loadingMore: function() {
                            return "Memuat lebih banyak hasil...";
                        }
                    },
                    templateResult: formatOption,
                    templateSelection: formatSelection,
                    escapeMarkup: function(markup) {
                        return markup;
                    }
                });
                
                // Handle Select2 events
                $select.on('select2:open', function() {
                    // Add custom styling to dropdown when opened
                    $('.select2-dropdown').addClass('custom-select2-dropdown');
                    
                    // Focus on search input if available
                    setTimeout(function() {
                        $('.select2-search__field').focus();
                    }, 100);
                });
                
                $select.on('select2:close', function() {
                    // Remove focus styling when closed
                    $(this).blur();
                });
                
                $select.on('select2:select', function(e) {
                    // Add animation when option is selected
                    var $container = $(this).next('.select2-container');
                    $container.addClass('select2-selected');
                    
                    setTimeout(function() {
                        $container.removeClass('select2-selected');
                    }, 300);
                });
            });
        }
    }

    /**
     * Format Select2 options
     */
    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }
        
        var $option = $(
            '<div class="select2-option-wrapper">' +
            '<span class="select2-option-text">' + option.text + '</span>' +
            '</div>'
        );
        
        return $option;
    }

    /**
     * Format Select2 selection
     */
    function formatSelection(selection) {
        return selection.text;
    }

    /**
     * Handle keyboard navigation for native selects
     */
    function handleKeyNavigation(e, $select) {
        var key = e.which || e.keyCode;
        
        switch(key) {
            case 27: // Escape
                $select.blur();
                break;
            case 13: // Enter
                if ($select.is(':focus')) {
                    $select.trigger('change');
                }
                break;
            case 38: // Up arrow
                e.preventDefault();
                navigateOption($select, -1);
                break;
            case 40: // Down arrow
                e.preventDefault();
                navigateOption($select, 1);
                break;
        }
    }

    /**
     * Navigate through select options
     */
    function navigateOption($select, direction) {
        var currentIndex = $select.prop('selectedIndex');
        var optionsLength = $select.find('option').length;
        var newIndex = currentIndex + direction;
        
        if (newIndex >= 0 && newIndex < optionsLength) {
            $select.prop('selectedIndex', newIndex);
            $select.trigger('change');
        }
    }

    /**
     * Handle select events
     */
    function handleSelectEvents() {
        // Handle focus events
        $(document).on('focus', 'select:not(.js-select2)', function() {
            $(this).addClass('select-focused');
        });
        
        $(document).on('blur', 'select:not(.js-select2)', function() {
            $(this).removeClass('select-focused');
        });
        
        // Handle change events
        $(document).on('change', 'select', function() {
            var $select = $(this);
            var value = $select.val();
            
            // Add validation styling
            if (value && value !== '') {
                $select.removeClass('is-invalid').addClass('is-valid');
            } else if ($select.prop('required')) {
                $select.removeClass('is-valid').addClass('is-invalid');
            }
            
            // Trigger custom event
            $select.trigger('select:changed', [value]);
        });
        
        // Handle form submission
        $(document).on('submit', 'form', function() {
            var $form = $(this);
            var isValid = true;
            
            $form.find('select[required]').each(function() {
                var $select = $(this);
                var value = $select.val();
                
                if (!value || value === '') {
                    $select.addClass('is-invalid');
                    isValid = false;
                } else {
                    $select.removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                // Focus on first invalid select
                $form.find('select.is-invalid').first().focus();
                return false;
            }
        });
    }

    /**
     * Create custom select dropdown (alternative to native select)
     */
    function createCustomDropdown($select) {
        var options = [];
        var placeholder = $select.attr('placeholder') || 'Pilih opsi...';
        var isMultiple = $select.prop('multiple');
        var isDisabled = $select.prop('disabled');
        
        $select.find('option').each(function() {
            var $option = $(this);
            options.push({
                value: $option.val(),
                text: $option.text(),
                selected: $option.prop('selected'),
                disabled: $option.prop('disabled')
            });
        });
        
        var $wrapper = $('<div class="custom-select-wrapper"></div>');
        var $trigger = $('<div class="custom-select-trigger">' + placeholder + '</div>');
        var $dropdown = $('<div class="custom-select-dropdown"></div>');
        
        if (isDisabled) {
            $wrapper.addClass('disabled');
        }
        
        if (isMultiple) {
            $wrapper.addClass('multiple');
        }
        
        // Build options
        options.forEach(function(option) {
            var $optionEl = $('<div class="custom-select-option" data-value="' + option.value + '">' + option.text + '</div>');
            
            if (option.selected) {
                $optionEl.addClass('selected');
                if (!isMultiple) {
                    $trigger.text(option.text);
                }
            }
            
            if (option.disabled) {
                $optionEl.addClass('disabled');
            }
            
            $dropdown.append($optionEl);
        });
        
        $wrapper.append($trigger).append($dropdown);
        
        // Handle events
        $trigger.on('click', function() {
            if (!isDisabled) {
                $wrapper.toggleClass('open');
            }
        });
        
        $dropdown.on('click', '.custom-select-option:not(.disabled)', function() {
            var $option = $(this);
            var value = $option.data('value');
            var text = $option.text();
            
            if (isMultiple) {
                $option.toggleClass('selected');
                $select.find('option[value="' + value + '"]').prop('selected', $option.hasClass('selected'));
            } else {
                $dropdown.find('.custom-select-option').removeClass('selected');
                $option.addClass('selected');
                $trigger.text(text);
                $select.val(value);
                $wrapper.removeClass('open');
            }
            
            $select.trigger('change');
        });
        
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
                $wrapper.removeClass('open');
            }
        });
        
        // Hide original select and replace with custom dropdown
        $select.hide().after($wrapper);
        
        return $wrapper;
    }

    /**
     * Refresh Select2 instances
     */
    function refreshSelect2() {
        $('.js-select2').each(function() {
            $(this).select2('destroy').select2();
        });
    }

    /**
     * Validate select field
     */
    function validateSelect($select) {
        var value = $select.val();
        var isRequired = $select.prop('required');
        var isValid = true;
        
        if (isRequired && (!value || value === '')) {
            isValid = false;
            $select.addClass('is-invalid');
        } else {
            $select.removeClass('is-invalid');
        }
        
        return isValid;
    }

    /**
     * Show loading state for select
     */
    function showSelectLoading($select) {
        if ($select.hasClass('js-select2')) {
            $select.prop('disabled', true);
            $select.next('.select2-container').addClass('select2-loading');
        } else {
            $select.prop('disabled', true);
            $select.addClass('loading');
        }
    }

    /**
     * Hide loading state for select
     */
    function hideSelectLoading($select) {
        if ($select.hasClass('js-select2')) {
            $select.prop('disabled', false);
            $select.next('.select2-container').removeClass('select2-loading');
        } else {
            $select.prop('disabled', false);
            $select.removeClass('loading');
        }
    }

    /**
     * Update select options dynamically
     */
    function updateSelectOptions($select, options) {
        $select.empty();
        
        if ($select.data('placeholder')) {
            $select.append('<option value="">' + $select.data('placeholder') + '</option>');
        }
        
        options.forEach(function(option) {
            $select.append('<option value="' + option.value + '"' + 
                (option.selected ? ' selected' : '') + 
                (option.disabled ? ' disabled' : '') + '>' + 
                option.text + '</option>');
        });
        
        if ($select.hasClass('js-select2')) {
            $select.trigger('change.select2');
        }
    }

    // Expose functions globally
    window.CustomSelect = {
        refresh: refreshSelect2,
        validate: validateSelect,
        showLoading: showSelectLoading,
        hideLoading: hideSelectLoading,
        updateOptions: updateSelectOptions
    };

})(jQuery);

// CSS for loading state
var loadingCSS = `
.select2-container.select2-loading .select2-selection--single {
    background-image: url('data:image/svg+xml;charset=utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="%23666" d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zm0-2A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/><path fill="%23666" d="M8 4a4 4 0 0 1 4 4h2a6 6 0 0 0-6-6z"><animateTransform attributeName="transform" type="rotate" from="0 8 8" to="360 8 8" dur="1s" repeatCount="indefinite"/></path></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px 16px;
}

.select2-selected {
    animation: selectPulse 0.3s ease-out;
}

@keyframes selectPulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.custom-select2-dropdown {
    animation: dropdownFadeIn 0.2s ease-out;
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
`;

// Inject CSS
var style = document.createElement('style');
style.textContent = loadingCSS;
document.head.appendChild(style);
