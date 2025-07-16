<?php

use Laravel\Dusk\Browser;
use App\Models\User;

// Test dashboard page loads correctly
test('dashboard page loads correctly', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('STEFIA Dashboard')
                ->assertSee('Total Mahasiswa')
                ->assertSee('Piutang Aktif')
                ->assertSee('Piutang Lunas')
                ->assertSee('Tunggakan Kritis')
                ->assertSee('Pembayaran Hari Ini')
                ->assertSee('Collection Rate');
    });
});

// Test dashboard statistics cards are present
test('dashboard statistics cards are present', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->waitFor('.stats-card')
                ->assertPresent('.stats-card')
                ->assertSeeIn('.stats-card', 'Total Mahasiswa')
                ->assertSeeIn('.stats-card', 'Piutang Aktif')
                ->assertSeeIn('.stats-card', 'Piutang Lunas');
    });
});

// Test dashboard charts are loaded
test('dashboard charts are loaded', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->waitFor('#monthlyRevenue')
                ->assertPresent('#monthlyRevenue')
                ->assertPresent('#receivableStatus')
                ->assertPresent('#paymentTrends')
                ->assertPresent('#totalStudents')
                ->assertPresent('#activeReceivables');
    });
});

// Test dashboard navigation buttons work
test('dashboard navigation buttons work', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Export Report')
                ->assertSee('Add Student')
                ->assertSee('Record Payment')
                ->assertPresent('a[href="#"]:contains("Export Report")')
                ->assertPresent('a[href="#"]:contains("Add Student")');
    });
});

// Test dashboard recent transactions section
test('dashboard recent transactions section', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Recent Transactions')
                ->assertSee('Recent Activities')
                ->assertPresent('.nk-tb-list')
                ->assertPresent('.timeline-list');
    });
});

// Test dashboard responsive design
test('dashboard responsive design', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->resize(1200, 800)
                ->assertSee('STEFIA Dashboard')
                ->resize(768, 1024)
                ->assertSee('STEFIA Dashboard')
                ->resize(375, 667)
                ->assertSee('STEFIA Dashboard');
    });
});

// Test dashboard tooltips functionality
test('dashboard tooltips functionality', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->waitFor('[data-bs-toggle="tooltip"]')
                ->assertPresent('[data-bs-toggle="tooltip"]')
                ->mouseover('[data-bs-toggle="tooltip"]:first');
    });
});

// Test dashboard background effects
test('dashboard background effects are present', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertPresent('.dashboard-bg-effects')
                ->assertPresent('.dashboard-particle')
                ->assertPresent('.dashboard-network-line')
                ->assertPresent('.dashboard-geometric');
    });
});
