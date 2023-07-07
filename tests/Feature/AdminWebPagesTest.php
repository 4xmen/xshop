<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Question;
use App\Models\Ticket;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Xmen\StarterKit\Models\Adv;
use Xmen\StarterKit\Models\Category;
use Xmen\StarterKit\Models\Clip;
use Xmen\StarterKit\Models\Comment;
use Xmen\StarterKit\Models\Gallery;
use Xmen\StarterKit\Models\Menu;
use Xmen\StarterKit\Models\Poll;
use Xmen\StarterKit\Models\Post;
use Xmen\StarterKit\Models\Slider;

class AdminWebPagesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.user.all'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.user.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.user.edit',$user->id));
        $response->assertStatus(200);


    }

    public function test_category_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.category.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.category.create'));
        $response->assertStatus(200);

        if (Category::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.category.edit',Category::first()->slug));
            $response->assertStatus(200);
        }

    }

    public function test_post_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.post.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.post.create'));
        $response->assertStatus(200);

        if (Post::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.post.edit',Post::first()->slug));
            $response->assertStatus(200);
        }

    }

    public function test_gallery_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.gallery.all'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.gallery.create'));
        $response->assertStatus(200);

        if (Gallery::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.gallery.edit',Gallery::first()->slug));
            $response->assertStatus(200);
        }

    }

    public function test_adv_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.adv.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.adv.create'));
        $response->assertStatus(200);

        if (Adv::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.adv.edit',Adv::first()->slug));
            $response->assertStatus(200);
        }

    }
    public function test_attachment_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.attachment.index'));
        $response->assertStatus(200);

    }

    public function test_cat_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.cat.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.cat.create'));
        $response->assertStatus(200);

        if (Cat::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.cat.edit',Cat::first()->slug));
            $response->assertStatus(200);
        }

    }
    public function test_clip_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.clip.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.clip.create'));
        $response->assertStatus(200);

        if (Clip::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.clip.edit',Clip::first()->slug));
            $response->assertStatus(200);
        }

    }
    public function test_comment_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.comment.index'));
        $response->assertStatus(200);

        if (Comment::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.comment.edit',Comment::first()->id));
            $response->assertStatus(200);
        }

    }
    public function test_contact_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.contact.index'));
        $response->assertStatus(200);

        if (Contact::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.contact.reply',Contact::first()->id));
            $response->assertStatus(200);
            $response = $this->actingAs($user)->get(route('admin.contact.show',Contact::first()->id));
            $response->assertStatus(200);
        }

    }

    public function test_customer_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.customer.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.customer.create'));
        $response->assertStatus(200);

        if (Customer::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.customer.edit',Customer::first()->slug));
            $response->assertStatus(200);
        }

    }
    public function test_discount_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.discount.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.discount.create'));
        $response->assertStatus(200);

        if (Discount::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.discount.edit',Discount::first()->id));
            $response->assertStatus(200);
        }

    }

    public function test_question_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.question.index'));
        $response->assertStatus(200);

        if (Question::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.question.edit',Question::first()->id));
            $response->assertStatus(200);
        }

    }
    public function test_invoice_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.invoice.index'));
        $response->assertStatus(200);

//        $response = $this->actingAs($user)->get(route('admin.invoice.create'));
//        $response->assertStatus(200);

        if (Invoice::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.invoice.edit',Invoice::first()->id));
            $response->assertStatus(200);
        }

    }
    public function test_menu_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.menu.index'));
        $response->assertStatus(200);


        if (Menu::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.menu.manage',Menu::first()->id));
            $response->assertStatus(200);
        }

    }

    public function test_slider_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.slider.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.slider.create'));
        $response->assertStatus(200);

        if (Slider::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.slider.edit',Slider::first()->id));
            $response->assertStatus(200);
        }

    }

    public function test_poll_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.poll.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.poll.create'));
        $response->assertStatus(200);

        if (Poll::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.poll.edit',Poll::first()->id));
            $response->assertStatus(200);
        }

    }
    public function test_product_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.product.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.product.create'));
        $response->assertStatus(200);

        if (Product::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.product.edit',Product::first()->slug));
            $response->assertStatus(200);
        }

    }


    public function test_ticket_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.ticket.index'));
        $response->assertStatus(200);

//        $response = $this->actingAs($user)->get(route('admin.ticket.create'));
//        $response->assertStatus(200);

        if (Ticket::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.ticket.edit',Ticket::first()->id));
            $response->assertStatus(200);
        }

    }
    public function test_transport_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.transport.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('admin.transport.create'));
        $response->assertStatus(200);

        if (Transport::count() != 0){
            $response = $this->actingAs($user)->get(route('admin.transport.edit',Transport::first()->id));
            $response->assertStatus(200);
        }

    }

    public function test_setting_urls()
    {

        $user = $this->getValidUser();

        $response = $this->actingAs($user)->get(route('admin.setting.index'));
        $response->assertStatus(200);

    }


    private function  getValidUser(){
        if (User::where('email','admin@example.com')->count() == 0){

            if (Role::where('name','super-admin')->count() == 0){
                $role = Role::create(['name' => 'super-admin']);
            }else{
                $role = Role::where('name','super-admin')->first();
            }

            $user = User::factory()->count(1)->create(['email' => 'admin@example.com']);
            $user->assignRole($role);
        }else{
            $user = User::where('email','admin@example.com')->first();
        }
        return $user;
    }
}
