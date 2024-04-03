<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "uid" => $this->uid,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "role" => $this->role,
            "date_of_birth" => $this->date_of_birth,
            "created_by" => $this->created_by,
            "insurance_company" => $this->insurance_company,
            "username" => $this->username,
            "address1" => $this->address1,
            "address2" => $this->address2,
            "date_of_birth" => $this->date_of_birth,
            "post_code" => $this->post_code,
            "profile_image" => $this->profile_image,
            "city" => $this->city,
            "country" => $this->country,
            "state" => $this->state,
            "manager_name" => $this->manager_name,
            "registered_via" => $this->registered_via,
            "status" => $this->status,
            "guide_status" => $this->guide_status,
            "module_id" => $this->module_id,
            "trackermodule" => $this->trackermodule,
            "balance" => $this->balance,
            "minute" => $this->minute,
            "extra_minutes" => $this->extra_minutes,
            "buy_minutes" => $this->buy_minutes,
            "sms" => $this->sms,
            "rate" => $this->rate,
            "context" => $this->context,
            "dialer" => $this->dialer,
            "auto_dialer" => $this->auto_dialer,
            "is_deleted" => $this->is_deleted,
            "career" => $this->career,
            "career_dialer" => $this->career_dialer,
            "mean_dialer" => $this->career_dialer,
            "did_credit" => $this->career_dialer,
            "extra_did_credit" => $this->career_dialer,
            "accountcode" => $this->career_dialer,
            "is_symmetry" => $this->career_dialer,
            "delete_record" => $this->career_dialer,
            "sent_mail" => $this->career_dialer,
            "reg_source" => $this->career_dialer,
            "created_at" => (string) $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
