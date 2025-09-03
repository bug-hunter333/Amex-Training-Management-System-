<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class EnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'trainee_name' => 'required|string|max:255|min:2',
            'trainee_email' => 'required|email|max:255',
            'trainee_phone' => 'required|string|max:20|min:10',
            'date_of_birth' => 'required|date|before:' . Carbon::now()->subYears(16)->format('Y-m-d'),
            'gender' => 'required|in:male,female,other',
            'education_level' => 'required|in:High School,Associate Degree,Bachelor\'s Degree,Master\'s Degree,PhD',
            'trainee_address' => 'required|string|max:1000|min:10',
            'previous_experience' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Course selection is required.',
            'course_id.exists' => 'Selected course is not valid.',
            'trainee_name.required' => 'Full name is required.',
            'trainee_name.min' => 'Name must be at least 2 characters long.',
            'trainee_name.max' => 'Name cannot exceed 255 characters.',
            'trainee_email.required' => 'Email address is required.',
            'trainee_email.email' => 'Please enter a valid email address.',
            'trainee_email.max' => 'Email cannot exceed 255 characters.',
            'trainee_phone.required' => 'Phone number is required.',
            'trainee_phone.min' => 'Phone number must be at least 10 characters long.',
            'trainee_phone.max' => 'Phone number cannot exceed 20 characters.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Please enter a valid date.',
            'date_of_birth.before' => 'You must be at least 16 years old to enroll.',
            'gender.required' => 'Gender selection is required.',
            'gender.in' => 'Please select a valid gender option.',
            'education_level.required' => 'Education level is required.',
            'education_level.in' => 'Please select a valid education level.',
            'trainee_address.required' => 'Address is required.',
            'trainee_address.min' => 'Address must be at least 10 characters long.',
            'trainee_address.max' => 'Address cannot exceed 1000 characters.',
            'previous_experience.max' => 'Previous experience description cannot exceed 2000 characters.',
        ];
    }

    /**
     * Get custom attribute names for validation messages
     */
    public function attributes(): array
    {
        return [
            'trainee_name' => 'full name',
            'trainee_email' => 'email address',
            'trainee_phone' => 'phone number',
            'date_of_birth' => 'date of birth',
            'education_level' => 'education level',
            'trainee_address' => 'address',
            'previous_experience' => 'previous experience',
        ];
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        // Clean phone number
        if ($this->has('trainee_phone')) {
            $phone = preg_replace('/[^0-9]/', '', $this->trainee_phone);
            $this->merge(['trainee_phone' => $phone]);
        }

        // Trim text fields
        if ($this->has('trainee_name')) {
            $this->merge(['trainee_name' => trim($this->trainee_name)]);
        }

        if ($this->has('trainee_email')) {
            $this->merge(['trainee_email' => strtolower(trim($this->trainee_email))]);
        }

        if ($this->has('trainee_address')) {
            $this->merge(['trainee_address' => trim($this->trainee_address)]);
        }

        if ($this->has('previous_experience')) {
            $this->merge(['previous_experience' => trim($this->previous_experience)]);
        }
    }
}