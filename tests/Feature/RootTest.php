<?php

it('redirects root to home', function () {
   $response = $this->get('/');
   $response->assertRedirect('/home');
});
