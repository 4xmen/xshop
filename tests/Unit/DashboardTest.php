<?php
use Tests\TestCase;

class DashboardTest extends TestCase
{
    
    public function test_adminlog_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.adminlog.index"));
        $response->assertStatus(200);
    }

    public function test_guestlog_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.guestlog.index"));
        $response->assertStatus(200);
    }

    public function test_rate_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.rate.index"));
        $response->assertStatus(200);
    }

    public function test_adv_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.adv.index"));
        $response->assertStatus(200);
    }

    public function test_adv_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.adv.create"));
        $response->assertStatus(200);
    }

    public function test_area_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.area.index"));
        $response->assertStatus(200);
    }

    public function test_attachment_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.attachment.index"));
        $response->assertStatus(200);
    }

    public function test_attachment_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.attachment.create"));
        $response->assertStatus(200);
    }

    public function test_category_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.category.index"));
        $response->assertStatus(200);
    }

    public function test_category_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.category.create"));
        $response->assertStatus(200);
    }

    public function test_city_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.city.index"));
        $response->assertStatus(200);
    }

    public function test_city_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.city.create"));
        $response->assertStatus(200);
    }

    public function test_clip_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.clip.index"));
        $response->assertStatus(200);
    }

    public function test_clip_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.clip.create"));
        $response->assertStatus(200);
    }

    public function test_contact_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.contact.index"));
        $response->assertStatus(200);
    }

    public function test_comment_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.comment.index"));
        $response->assertStatus(200);
    }

    public function test_customer_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.customer.index"));
        $response->assertStatus(200);
    }

    public function test_customer_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.customer.create"));
        $response->assertStatus(200);
    }

    public function test_discount_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.discount.index"));
        $response->assertStatus(200);
    }

    public function test_discount_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.discount.create"));
        $response->assertStatus(200);
    }

    public function test_evaluation_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.evaluation.index"));
        $response->assertStatus(200);
    }

    public function test_evaluation_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.evaluation.create"));
        $response->assertStatus(200);
    }

    public function test_gallery_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.gallery.index"));
        $response->assertStatus(200);
    }

    public function test_gallery_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.gallery.create"));
        $response->assertStatus(200);
    }

    public function test_gfx_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.gfx.index"));
        $response->assertStatus(200);
    }

    public function test_group_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.group.index"));
        $response->assertStatus(200);
    }

    public function test_group_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.group.create"));
        $response->assertStatus(200);
    }

    public function test_creator_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.creator.index"));
        $response->assertStatus(200);
    }

    public function test_creator_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.creator.create"));
        $response->assertStatus(200);
    }

    public function test_invoice_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.invoice.index"));
        $response->assertStatus(200);
    }

    public function test_lang_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.lang.index"));
        $response->assertStatus(200);
    }

    public function test_lang_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.lang.create"));
        $response->assertStatus(200);
    }

    public function test_menu_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.menu.index"));
        $response->assertStatus(200);
    }

    public function test_menu_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.menu.create"));
        $response->assertStatus(200);
    }

    public function test_post_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.post.index"));
        $response->assertStatus(200);
    }

    public function test_post_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.post.create"));
        $response->assertStatus(200);
    }

    public function test_product_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.product.index"));
        $response->assertStatus(200);
    }

    public function test_product_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.product.create"));
        $response->assertStatus(200);
    }

    public function test_prop_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.prop.index"));
        $response->assertStatus(200);
    }

    public function test_prop_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.prop.create"));
        $response->assertStatus(200);
    }

    public function test_redirect_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.redirect.index"));
        $response->assertStatus(200);
    }

    public function test_redirect_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.redirect.create"));
        $response->assertStatus(200);
    }

    public function test_question_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.question.index"));
        $response->assertStatus(200);
    }

    public function test_report_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.report.index"));
        $response->assertStatus(200);
    }

    public function test_setting_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.setting.index"));
        $response->assertStatus(200);
    }

    public function test_slider_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.slider.index"));
        $response->assertStatus(200);
    }

    public function test_slider_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.slider.create"));
        $response->assertStatus(200);
    }

    public function test_state_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.state.index"));
        $response->assertStatus(200);
    }

    public function test_state_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.state.create"));
        $response->assertStatus(200);
    }

    public function test_story_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.story.index"));
        $response->assertStatus(200);
    }

    public function test_story_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.story.create"));
        $response->assertStatus(200);
    }

    public function test_tag_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.tag.index"));
        $response->assertStatus(200);
    }

    public function test_ticket_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.ticket.index"));
        $response->assertStatus(200);
    }

    public function test_transport_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.transport.index"));
        $response->assertStatus(200);
    }

    public function test_transport_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.transport.create"));
        $response->assertStatus(200);
    }

    public function test_user_index(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.user.index"));
        $response->assertStatus(200);
    }

    public function test_user_create(): void
    {
        $admin = \App\Models\User::where('role','DEVELOPER')->firstOrFail();
        $response = $this->actingAs($admin)->get(route("admin.user.create"));
        $response->assertStatus(200);
    }

}
