<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ContactType;
use App\Entity\Phone;
use App\Enums\CustomerStatus;
use App\Enums\Gender;
use App\Contracts\BaseDTO;
use App\Contracts\Validation\Rule\PhoneRule;

class CustomerAddDTO implements BaseDTO
{
    protected ?string $email;
    protected Phone  $phone;
    protected string $firstName;
    protected string $lastName;
    protected ?string $secondName    = null;
    protected string $password;
    protected bool $mailingAgree     = true;
    protected bool $smsAgree         = true;
    protected ?ContactType $prefConn = null;
    protected ?Carbon $birthdate     = null;
    protected ?Gender $gender        = null;
    protected CustomerStatus $status;

    public function __construct(array $fields)
    {
        $this->email             = $fields['email'] ?? null;
        $this->phone             = new Phone($fields['phone']);
        $this->firstName         = Str::title($fields['firstName']);
        $this->lastName          = Str::title($fields['lastName']);
        $this->secondName        = Str::title($fields['secondName'] ?? '');
        $this->mailingAgree      = !empty($fields['mailingAgree']);
        $this->smsAgree          = !empty($fields['smsAgree']);

        if (isset($fields['status'])) {
            $this->status = CustomerStatus::from((int) $fields['status']);
        }

        if (isset($fields['birthdate'])) {
            $this->birthdate = Carbon::parse($fields['birthdate']);
        }

        if (isset($fields['prefConn'])) {
            $this->prefConn = ContactType::fromValue($fields['prefConn']);
        }

        if (isset($fields['gender'])) {
            $this->gender = Gender::fromValue($fields['gender']);
        }
    }

//    protected function validate(array $fields)
//    {
//        $validator = Validator::make(
//            $fields,
//            $this->rules(),
//            $this->messages()
//        );
//
//        $validator->validate();
//    }
//
//    protected function rules()
//    {
//        return [
//            'firstName'   => ['required', 'bail', 'string', 'max:191'],
//            'lastName'    => ['required', 'bail', 'string', 'max:191'],
//            'secondName'  => ['nullable', 'bail', 'string', 'max:191'],
//            'birthdate'   => ['required', 'bail', 'date',   'before:today'],
//            'email'       => ['nullable', 'bail', 'email', 'max:191'],
//            'phone'       => ['required', 'bail', new PhoneRule],
//            'gender'      => ['required', 'bail', Rule::in(Gender::getValues())],
//            'prefConn'    => ['required', 'bail', Rule::in(ContactType::getValues())],
//            'status'      => ['nullable', 'bail', new Enum(CustomerStatus::class)],
//        ];
//    }
//
//    public function messages(): array
//    {
//        return [
//            'email.required'       => __('customer.email_required'),
//            'email.email'          => __('customer.email_required'),
//            'email.max'            => __('customer.email_required'),
//            'phone.required'       => __('customer.phone_required'),
//            'phone.regex'          => __('customer.phone_mallformed'),
//            'password.required'    => __('customer.password_required'),
//            'firstName.required'   => __('customer.first_name_required'),
//            'lastName.required'    => __('customer.last_name_required'),
//            'secondName.string'    => __('customer.second_name_required'),
//            'birthdate.required'   => __('customer.birthdate_required'),
//            'birthdate.date'       => __('customer.birthdate_invalid'),
//            'birthdate.before'     => __('customer.birthdate_invalid'),
//            'gender.required'      => __('customer.gender_required'),
//            'prefConn.required'    => __('customer.pref_conn_required'),
//        ];
//    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function getBirthdate(): ?Carbon
    {
        return $this->birthdate->format('d-m-y H:i:s');
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPrefConn(): ?ContactType
    {
        return $this->prefConn;
    }

    public function getMailingAgree(): bool
    {
        return $this->mailingAgree;
    }

    public function getSmsAgree(): bool
    {
        return $this->smsAgree;
    }

    public function getStatus(): CustomerStatus
    {
        return $this->status;
    }

    public function __serialize(): array
    {
        return [
            'email'        => $this->email,
            'phone'        => $this->phone,
            'firstName'    => $this->firstName,
            'lastName'     => $this->lastName,
            'secondName'   => $this->secondName,
            'mailingAgree' => $this->mailingAgree,
            'smsAgree'     => $this->smsAgree,
            'prefConn'     => $this->prefConn?->value,
            'birthdate'    => $this->birthdate?->timestamp,
            'gender'       => $this->gender?->value,
            'status'       => $this->status->value,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->email        = $data['email'];
        $this->phone        = $data['phone'];
        $this->firstName    = $data['firstName'];
        $this->lastName     = $data['lastName'];
        $this->secondName   = $data['secondName'];
        $this->mailingAgree = $data['mailingAgree'];
        $this->prefConn     = transform($data['prefConn'],  static fn ($v) => ContactType::fromValue($v));
        $this->birthdate    = transform($data['birthdate'], static fn ($v) => Carbon::createFromTimestamp($v));
        $this->gender       = transform($data['gender'],    static fn ($v) => Gender::fromValue($v));
        $this->status       = CustomerStatus::from($data['status']);
    }
}
