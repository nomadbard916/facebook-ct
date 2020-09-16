<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->actingAs($user = factory(\App\User::class)->create(), 'api');

        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body'
                ]
            ]
        ]);

        $post = Post::first();

        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing Body', $post->body);
        $this->assertCount(1, Post::all());

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name
                                ]
                            ]
                        ],
                        'body' => $post->body,
                    ]
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id)
                ]
            ]);
    }
}
