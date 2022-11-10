<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CommentTest extends TestCase
{
    // /** @test */
    // public function testCreateComment()
    // {
    //     $user = User::factory()->create();

    //     $test_post = [
    //         'title' => 'My test post with comment',
    //         'body' => 'This is a test functional post',
    //         'is_draft' => false
    //     ];
    //     $response = $this->actingAs($user)->post('/admin/posts', $test_post);
    //     $response->assertSessionHas('status', 'Post has been created sucessfully');

    //     $post = Post::where('title', $test_post['title'])->first();

    //     $comment = 'This is a test comment';
    //     $test_comment = [
    //         'post_id' => $post->id,
    //         'comment' => $comment
    //     ];
    //     $response = $this->actingAs($user)->post('/comment', $test_comment);
    //     $response->assertSessionHas('status', 'Comment has been created sucessfully');

    //     $comment = Comment::where('user_id', $user->id)
    //     ->where('post_id', $post->id)
    //     ->where('comment', $comment)->first();

    //     $this->assertNotNull($comment);

    //     $this->post('/logout');

    //     // Ahora probamos con un usuario sin loguear
    //     $response = $this->post('/comment', $test_comment);
    //     $response->assertStatus(403);
    // }

    // public function testCreatePost()
    // {
    //     $this->withoutExceptionHandling();

    //     $user = User::factory()->create();
    //     $title = 'My test post';
    //     $response = $this->actingAs($user)->post('/admin/posts', [
    //         'title' => $title,
    //         'body' => 'This is a test functional post',
    //         'is_draft' => false
    //     ]);
    //     $response->assertSessionHas('status', 'Post has been created sucessfully');
    //     $response->assertRedirect();

    //     // Con unique == false no revisa en la base posts y entonces no se raya con que sea un duplicado
    //     $slug_url = SlugService::createSlug(Post::class, 'slug', $title, ['unique' => false]);

    //     $response = $this->get('/posts/' . $slug_url);
    //     $response->assertStatus(200);

    //     $title .= '2';
    //     $response = $this->actingAs($user)->post('/admin/posts', [
    //         'title' => $title,
    //         'body' => 'This is a test functional post',
    //         'is_draft' => true
    //     ]);
    //     $response->assertSessionHas('status', 'Post has been created sucessfully');
    //     $response->assertRedirect();

    //     // Con unique == false no revisa en la base posts y entonces no se raya con que sea un duplicado
    //     $slug_url = SlugService::createSlug(Post::class, 'slug', $title, ['unique' => false]);

    //     $response = $this->get('/posts/' . $slug_url);
    //     $response->assertStatus(404);

    //     $response = $this->actingAs($user)->post('/admin/posts', []);
    //     $response->assertSessionHasErrors([
    //         'title' => 'A title is required',
    //         'body' => 'You must sent a body',
    //         'is_draft' => 'You must sent if is draft or not'
    //     ]);
    // }

    // public function test_user_can_view_a_login_form()
    // {
    //     $response = $this->get('/login');

    //     $response->assertSuccessful();
    //     $response->assertViewIs('auth.login');
    // }

    // public function test_user_cannot_view_a_login_form_when_authenticated()
    // {
    //     // $user = User::factory()->make();

    //     // $response = $this->actingAs($user)->get('/login');

    //     // $response->assertRedirect('/home');
    //     $this->get('/login')->assertSee('Login');
    //     $credentials = [
    //         "email" => "test@test.com",
    //         "password" => "123456"
    //     ];

    //     $response = $this->post('/login', $credentials);
    //     $response->assertRedirect('/home');
    //     $this->assertCredentials($credentials);
    // }
}
