<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Welcome Back');
    $response->assertSee('TERA');
});

test('admin can authenticate and is redirected to admin dashboard', function () {
    $admin = User::create([
        'username' => 'testadmin',
        'nama' => 'Test Admin',
        'name' => 'Test Admin',
        'email' => 'testadmin@tera.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    $response = $this->post('/login', [
        'login' => 'testadmin@tera.com',
        'password' => 'password123',
    ]);

    $this->assertAuthenticatedAs($admin);
    $response->assertRedirect(route('admin.dashboard'));
});

test('pelanggan can authenticate using username and is redirected to pelanggan dashboard', function () {
    $pelanggan = User::create([
        'username' => 'testpelanggan',
        'nama' => 'Test Pelanggan',
        'name' => 'Test Pelanggan',
        'email' => 'testpelanggan@tera.com',
        'password' => bcrypt('password123'),
        'role' => 'pelanggan',
    ]);

    $response = $this->post('/login', [
        'login' => 'testpelanggan',
        'password' => 'password123',
    ]);

    $this->assertAuthenticatedAs($pelanggan);
    $response->assertRedirect(route('pelanggan.dashboard'));
});

test('users cannot authenticate with invalid password and receive SRS error message', function () {
    $user = User::create([
        'username' => 'userfail',
        'nama' => 'User Fail',
        'email' => 'fail@tera.com',
        'password' => bcrypt('password123'),
        'role' => 'pelanggan',
    ]);

    $response = $this->post('/login', [
        'login' => 'fail@tera.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors([
        'login' => 'Username atau password salah.',
    ]);
});

test('users can logout and are redirected to login page with status', function () {
    $user = User::create([
        'username' => 'logoutuser',
        'nama' => 'Logout User',
        'email' => 'logout@tera.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status', 'Anda telah berhasil keluar dari sistem.');
});
