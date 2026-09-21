<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Daftar Akun Baru');
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'nama' => 'Pelanggan Baru',
        'username' => 'pelangganbaru',
        'email' => 'baru@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('pelanggan.dashboard'));
});
