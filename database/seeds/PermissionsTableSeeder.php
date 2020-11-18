<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_status_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_status_edit',
            ],
            [
                'id'    => 19,
                'title' => 'user_status_show',
            ],
            [
                'id'    => 20,
                'title' => 'user_status_delete',
            ],
            [
                'id'    => 21,
                'title' => 'user_status_access',
            ],
            [
                'id'    => 22,
                'title' => 'slide_show_create',
            ],
            [
                'id'    => 23,
                'title' => 'slide_show_edit',
            ],
            [
                'id'    => 24,
                'title' => 'slide_show_show',
            ],
            [
                'id'    => 25,
                'title' => 'slide_show_delete',
            ],
            [
                'id'    => 26,
                'title' => 'slide_show_access',
            ],
            [
                'id'    => 27,
                'title' => 'restaurant_create',
            ],
            [
                'id'    => 28,
                'title' => 'restaurant_edit',
            ],
            [
                'id'    => 29,
                'title' => 'restaurant_show',
            ],
            [
                'id'    => 30,
                'title' => 'restaurant_delete',
            ],
            [
                'id'    => 31,
                'title' => 'restaurant_access',
            ],
            [
                'id'    => 32,
                'title' => 'delivery_create',
            ],
            [
                'id'    => 33,
                'title' => 'delivery_edit',
            ],
            [
                'id'    => 34,
                'title' => 'delivery_show',
            ],
            [
                'id'    => 35,
                'title' => 'delivery_delete',
            ],
            [
                'id'    => 36,
                'title' => 'delivery_access',
            ],
            [
                'id'    => 37,
                'title' => 'payment_method_create',
            ],
            [
                'id'    => 38,
                'title' => 'payment_method_edit',
            ],
            [
                'id'    => 39,
                'title' => 'payment_method_show',
            ],
            [
                'id'    => 40,
                'title' => 'payment_method_delete',
            ],
            [
                'id'    => 41,
                'title' => 'payment_method_access',
            ],
            [
                'id'    => 42,
                'title' => 'category_create',
            ],
            [
                'id'    => 43,
                'title' => 'category_edit',
            ],
            [
                'id'    => 44,
                'title' => 'category_show',
            ],
            [
                'id'    => 45,
                'title' => 'category_delete',
            ],
            [
                'id'    => 46,
                'title' => 'category_access',
            ],
            [
                'id'    => 47,
                'title' => 'item_create',
            ],
            [
                'id'    => 48,
                'title' => 'item_edit',
            ],
            [
                'id'    => 49,
                'title' => 'item_show',
            ],
            [
                'id'    => 50,
                'title' => 'item_delete',
            ],
            [
                'id'    => 51,
                'title' => 'item_access',
            ],
            [
                'id'    => 52,
                'title' => 'sitting_area_create',
            ],
            [
                'id'    => 53,
                'title' => 'sitting_area_edit',
            ],
            [
                'id'    => 54,
                'title' => 'sitting_area_show',
            ],
            [
                'id'    => 55,
                'title' => 'sitting_area_delete',
            ],
            [
                'id'    => 56,
                'title' => 'sitting_area_access',
            ],
            [
                'id'    => 57,
                'title' => 'delivery_company_create',
            ],
            [
                'id'    => 58,
                'title' => 'delivery_company_edit',
            ],
            [
                'id'    => 59,
                'title' => 'delivery_company_show',
            ],
            [
                'id'    => 60,
                'title' => 'delivery_company_delete',
            ],
            [
                'id'    => 61,
                'title' => 'delivery_company_access',
            ],
            [
                'id'    => 62,
                'title' => 'reporting_create',
            ],
            [
                'id'    => 63,
                'title' => 'reporting_edit',
            ],
            [
                'id'    => 64,
                'title' => 'reporting_show',
            ],
            [
                'id'    => 65,
                'title' => 'reporting_delete',
            ],
            [
                'id'    => 66,
                'title' => 'reporting_access',
            ],
            [
                'id'    => 67,
                'title' => 'rate_create',
            ],
            [
                'id'    => 68,
                'title' => 'rate_edit',
            ],
            [
                'id'    => 69,
                'title' => 'rate_show',
            ],
            [
                'id'    => 70,
                'title' => 'rate_delete',
            ],
            [
                'id'    => 71,
                'title' => 'rate_access',
            ],
            [
                'id'    => 72,
                'title' => 'cart_create',
            ],
            [
                'id'    => 73,
                'title' => 'cart_edit',
            ],
            [
                'id'    => 74,
                'title' => 'cart_show',
            ],
            [
                'id'    => 75,
                'title' => 'cart_delete',
            ],
            [
                'id'    => 76,
                'title' => 'cart_access',
            ],
            [
                'id'    => 77,
                'title' => 'address_create',
            ],
            [
                'id'    => 78,
                'title' => 'address_edit',
            ],
            [
                'id'    => 79,
                'title' => 'address_show',
            ],
            [
                'id'    => 80,
                'title' => 'address_delete',
            ],
            [
                'id'    => 81,
                'title' => 'address_access',
            ],
            [
                'id'    => 82,
                'title' => 'save_credit_card_create',
            ],
            [
                'id'    => 83,
                'title' => 'save_credit_card_edit',
            ],
            [
                'id'    => 84,
                'title' => 'save_credit_card_show',
            ],
            [
                'id'    => 85,
                'title' => 'save_credit_card_delete',
            ],
            [
                'id'    => 86,
                'title' => 'save_credit_card_access',
            ],
            [
                'id'    => 87,
                'title' => 'country_create',
            ],
            [
                'id'    => 88,
                'title' => 'country_edit',
            ],
            [
                'id'    => 89,
                'title' => 'country_show',
            ],
            [
                'id'    => 90,
                'title' => 'country_delete',
            ],
            [
                'id'    => 91,
                'title' => 'country_access',
            ],
            [
                'id'    => 92,
                'title' => 'city_create',
            ],
            [
                'id'    => 93,
                'title' => 'city_edit',
            ],
            [
                'id'    => 94,
                'title' => 'city_show',
            ],
            [
                'id'    => 95,
                'title' => 'city_delete',
            ],
            [
                'id'    => 96,
                'title' => 'city_access',
            ],
            [
                'id'    => 97,
                'title' => 'currency_create',
            ],
            [
                'id'    => 98,
                'title' => 'currency_edit',
            ],
            [
                'id'    => 99,
                'title' => 'currency_show',
            ],
            [
                'id'    => 100,
                'title' => 'currency_delete',
            ],
            [
                'id'    => 101,
                'title' => 'currency_access',
            ],
            [
                'id'    => 102,
                'title' => 'subscription_package_create',
            ],
            [
                'id'    => 103,
                'title' => 'subscription_package_edit',
            ],
            [
                'id'    => 104,
                'title' => 'subscription_package_show',
            ],
            [
                'id'    => 105,
                'title' => 'subscription_package_delete',
            ],
            [
                'id'    => 106,
                'title' => 'subscription_package_access',
            ],
            [
                'id'    => 107,
                'title' => 'subscription_access',
            ],
            [
                'id'    => 108,
                'title' => 'ad_access',
            ],
            [
                'id'    => 109,
                'title' => 'ads_category_create',
            ],
            [
                'id'    => 110,
                'title' => 'ads_category_edit',
            ],
            [
                'id'    => 111,
                'title' => 'ads_category_show',
            ],
            [
                'id'    => 112,
                'title' => 'ads_category_delete',
            ],
            [
                'id'    => 113,
                'title' => 'ads_category_access',
            ],
            [
                'id'    => 114,
                'title' => 'all_ad_create',
            ],
            [
                'id'    => 115,
                'title' => 'all_ad_edit',
            ],
            [
                'id'    => 116,
                'title' => 'all_ad_show',
            ],
            [
                'id'    => 117,
                'title' => 'all_ad_delete',
            ],
            [
                'id'    => 118,
                'title' => 'all_ad_access',
            ],
            [
                'id'    => 119,
                'title' => 'restaurants_management_access',
            ],
            [
                'id'    => 120,
                'title' => 'delivery_management_access',
            ],
            [
                'id'    => 121,
                'title' => 'order_create',
            ],
            [
                'id'    => 122,
                'title' => 'order_edit',
            ],
            [
                'id'    => 123,
                'title' => 'order_show',
            ],
            [
                'id'    => 124,
                'title' => 'order_delete',
            ],
            [
                'id'    => 125,
                'title' => 'order_access',
            ],
            [
                'id'    => 126,
                'title' => 'extra_create',
            ],
            [
                'id'    => 127,
                'title' => 'extra_edit',
            ],
            [
                'id'    => 128,
                'title' => 'extra_show',
            ],
            [
                'id'    => 129,
                'title' => 'extra_delete',
            ],
            [
                'id'    => 130,
                'title' => 'extra_access',
            ],
            [
                'id'    => 131,
                'title' => 'order_mangement_access',
            ],
            [
                'id'    => 132,
                'title' => 'order_type_create',
            ],
            [
                'id'    => 133,
                'title' => 'order_type_edit',
            ],
            [
                'id'    => 134,
                'title' => 'order_type_show',
            ],
            [
                'id'    => 135,
                'title' => 'order_type_delete',
            ],
            [
                'id'    => 136,
                'title' => 'order_type_access',
            ],
            [
                'id'    => 137,
                'title' => 'order_status_create',
            ],
            [
                'id'    => 138,
                'title' => 'order_status_edit',
            ],
            [
                'id'    => 139,
                'title' => 'order_status_show',
            ],
            [
                'id'    => 140,
                'title' => 'order_status_delete',
            ],
            [
                'id'    => 141,
                'title' => 'order_status_access',
            ],
            [
                'id'    => 142,
                'title' => 'otherbranch_create',
            ],
            [
                'id'    => 143,
                'title' => 'otherbranch_edit',
            ],
            [
                'id'    => 144,
                'title' => 'otherbranch_show',
            ],
            [
                'id'    => 145,
                'title' => 'otherbranch_delete',
            ],
            [
                'id'    => 146,
                'title' => 'otherbranch_access',
            ],
            [
                'id'    => 147,
                'title' => 'cansel_reason_create',
            ],
            [
                'id'    => 148,
                'title' => 'cansel_reason_edit',
            ],
            [
                'id'    => 149,
                'title' => 'cansel_reason_show',
            ],
            [
                'id'    => 150,
                'title' => 'cansel_reason_delete',
            ],
            [
                'id'    => 151,
                'title' => 'cansel_reason_access',
            ],
            [
                'id'    => 152,
                'title' => 'favorite_create',
            ],
            [
                'id'    => 153,
                'title' => 'favorite_edit',
            ],
            [
                'id'    => 154,
                'title' => 'favorite_show',
            ],
            [
                'id'    => 155,
                'title' => 'favorite_delete',
            ],
            [
                'id'    => 156,
                'title' => 'favorite_access',
            ],
            [
                'id'    => 157,
                'title' => 'faq_create',
            ],
            [
                'id'    => 158,
                'title' => 'faq_edit',
            ],
            [
                'id'    => 159,
                'title' => 'faq_show',
            ],
            [
                'id'    => 160,
                'title' => 'faq_delete',
            ],
            [
                'id'    => 161,
                'title' => 'faq_access',
            ],
            [
                'id'    => 162,
                'title' => 'ticket_create',
            ],
            [
                'id'    => 163,
                'title' => 'ticket_edit',
            ],
            [
                'id'    => 164,
                'title' => 'ticket_show',
            ],
            [
                'id'    => 165,
                'title' => 'ticket_delete',
            ],
            [
                'id'    => 166,
                'title' => 'ticket_access',
            ],
            [
                'id'    => 167,
                'title' => 'ticketmanagement_access',
            ],
            [
                'id'    => 168,
                'title' => 'ticket_status_create',
            ],
            [
                'id'    => 169,
                'title' => 'ticket_status_edit',
            ],
            [
                'id'    => 170,
                'title' => 'ticket_status_show',
            ],
            [
                'id'    => 171,
                'title' => 'ticket_status_delete',
            ],
            [
                'id'    => 172,
                'title' => 'ticket_status_access',
            ],
            [
                'id'    => 173,
                'title' => 'coupon_create',
            ],
            [
                'id'    => 174,
                'title' => 'coupon_edit',
            ],
            [
                'id'    => 175,
                'title' => 'coupon_show',
            ],
            [
                'id'    => 176,
                'title' => 'coupon_delete',
            ],
            [
                'id'    => 177,
                'title' => 'coupon_access',
            ],
            [
                'id'    => 178,
                'title' => 'place_access',
            ],
            [
                'id'    => 179,
                'title' => 'notification_create',
            ],
            [
                'id'    => 180,
                'title' => 'notification_edit',
            ],
            [
                'id'    => 181,
                'title' => 'notification_show',
            ],
            [
                'id'    => 182,
                'title' => 'notification_delete',
            ],
            [
                'id'    => 183,
                'title' => 'notification_access',
            ],
            [
                'id'    => 184,
                'title' => 'subscription_vip_create',
            ],
            [
                'id'    => 185,
                'title' => 'subscription_vip_edit',
            ],
            [
                'id'    => 186,
                'title' => 'subscription_vip_show',
            ],
            [
                'id'    => 187,
                'title' => 'subscription_vip_delete',
            ],
            [
                'id'    => 188,
                'title' => 'subscription_vip_access',
            ],
            [
                'id'    => 189,
                'title' => 'point_create',
            ],
            [
                'id'    => 190,
                'title' => 'point_edit',
            ],
            [
                'id'    => 191,
                'title' => 'point_show',
            ],
            [
                'id'    => 192,
                'title' => 'point_delete',
            ],
            [
                'id'    => 193,
                'title' => 'point_access',
            ],
            [
                'id'    => 194,
                'title' => 'point_management_access',
            ],
            [
                'id'    => 195,
                'title' => 'point_type_create',
            ],
            [
                'id'    => 196,
                'title' => 'point_type_edit',
            ],
            [
                'id'    => 197,
                'title' => 'point_type_show',
            ],
            [
                'id'    => 198,
                'title' => 'point_type_delete',
            ],
            [
                'id'    => 199,
                'title' => 'point_type_access',
            ],
            [
                'id'    => 200,
                'title' => 'onbordering_create',
            ],
            [
                'id'    => 201,
                'title' => 'onbordering_edit',
            ],
            [
                'id'    => 202,
                'title' => 'onbordering_show',
            ],
            [
                'id'    => 203,
                'title' => 'onbordering_delete',
            ],
            [
                'id'    => 204,
                'title' => 'onbordering_access',
            ],
            [
                'id'    => 205,
                'title' => 'table_create',
            ],
            [
                'id'    => 206,
                'title' => 'table_edit',
            ],
            [
                'id'    => 207,
                'title' => 'table_show',
            ],
            [
                'id'    => 208,
                'title' => 'table_delete',
            ],
            [
                'id'    => 209,
                'title' => 'table_access',
            ],
            [
                'id'    => 210,
                'title' => 'table_status_create',
            ],
            [
                'id'    => 211,
                'title' => 'table_status_edit',
            ],
            [
                'id'    => 212,
                'title' => 'table_status_show',
            ],
            [
                'id'    => 213,
                'title' => 'table_status_delete',
            ],
            [
                'id'    => 214,
                'title' => 'table_status_access',
            ],
            [
                'id'    => 215,
                'title' => 'subscription_user_create',
            ],
            [
                'id'    => 216,
                'title' => 'subscription_user_edit',
            ],
            [
                'id'    => 217,
                'title' => 'subscription_user_show',
            ],
            [
                'id'    => 218,
                'title' => 'subscription_user_delete',
            ],
            [
                'id'    => 219,
                'title' => 'subscription_user_access',
            ],
            [
                'id'    => 220,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 221,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 222,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 223,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 224,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
