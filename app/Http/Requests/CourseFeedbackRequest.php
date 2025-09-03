<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled in the controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'feedback' => [
                'required',
                'string',
                'min:10',
                'max:2000'
            ],
            'categories' => [
                'nullable',
                'array',
                'max:6' // Maximum 6 categories
            ],
            'categories.*' => [
                'string',
                Rule::in(['content', 'instructor', 'delivery', 'materials', 'support', 'overall'])
            ],
            'is_anonymous' => [
                'boolean'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Please provide a rating for this course.',
            'rating.integer' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
            'feedback.required' => 'Please provide your feedback.',
            'feedback.min' => 'Feedback must be at least 10 characters long.',
            'feedback.max' => 'Feedback cannot exceed 2000 characters.',
            'categories.max' => 'You can select a maximum of 6 feedback categories.',
            'categories.*.in' => 'Invalid feedback category selected.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'rating' => 'course rating',
            'feedback' => 'feedback text',
            'categories' => 'feedback categories',
            'is_anonymous' => 'anonymous setting',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure is_anonymous is boolean
        $this->merge([
            'is_anonymous' => $this->boolean('is_anonymous', false),
        ]);

        // Clean up categories array
        if ($this->has('categories') && is_array($this->categories)) {
            $this->merge([
                'categories' => array_filter(array_unique($this->categories))
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Additional custom validation logic can go here
            
            // Check if feedback contains inappropriate content (basic check)
            if ($this->has('feedback')) {
                $feedback = strtolower($this->feedback);
                $inappropriateWords = ['spam', 'fake', 'scam']; // Add more as needed
                
                foreach ($inappropriateWords as $word) {
                    if (strpos($feedback, $word) !== false) {
                        $validator->errors()->add('feedback', 'Your feedback contains inappropriate content.');
                        break;
                    }
                }
            }
        });
    }
}