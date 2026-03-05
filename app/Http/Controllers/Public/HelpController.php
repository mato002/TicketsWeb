<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'category' => 'General',
                'questions' => [
                    [
                        'question' => 'How do I book tickets for a concert?',
                        'answer' => 'Simply browse our concerts, select the one you want to attend, choose your ticket category and quantity, then proceed to checkout. You can book without creating an account, but we recommend signing up to manage your bookings easily.'
                    ],
                    [
                        'question' => 'Can I cancel my booking?',
                        'answer' => 'Yes, you can cancel your booking up to 24 hours before the event. Refunds are processed within 5-7 business days to your original payment method.'
                    ],
                    [
                        'question' => 'Are there any booking fees?',
                        'answer' => 'We charge a small processing fee of $2.50 per booking to cover payment processing and platform maintenance costs.'
                    ]
                ]
            ],
            [
                'category' => 'Tickets',
                'questions' => [
                    [
                        'question' => 'What ticket categories are available?',
                        'answer' => 'Ticket categories vary by concert but typically include General Admission, VIP, and Premium options. Each category offers different benefits and pricing.'
                    ],
                    [
                        'question' => 'How will I receive my tickets?',
                        'answer' => 'Tickets are sent to your email address immediately after purchase. You can also access them in your account dashboard.'
                    ],
                    [
                        'question' => 'Can I transfer my tickets to someone else?',
                        'answer' => 'Yes, you can transfer tickets to another person up to 2 hours before the event starts. Use the transfer option in your booking details.'
                    ]
                ]
            ],
            [
                'category' => 'Accommodation',
                'questions' => [
                    [
                        'question' => 'How do I book accommodation?',
                        'answer' => 'During checkout, you can browse and select accommodation options near your concert venue. All bookings are handled through our trusted partner accommodations.'
                    ],
                    [
                        'question' => 'Can I modify my accommodation booking?',
                        'answer' => 'Yes, you can modify dates or cancel your accommodation booking up to 48 hours before check-in, subject to the accommodation\'s cancellation policy.'
                    ],
                    [
                        'question' => 'Are accommodation prices per person or per room?',
                        'answer' => 'All accommodation prices shown are per room per night, not per person. Additional guest fees may apply for some accommodations.'
                    ]
                ]
            ],
            [
                'category' => 'Payment',
                'questions' => [
                    [
                        'question' => 'What payment methods do you accept?',
                        'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and Apple Pay for your convenience.'
                    ],
                    [
                        'question' => 'Is my payment information secure?',
                        'answer' => 'Yes, all payments are processed securely using industry-standard encryption. We never store your complete payment information on our servers.'
                    ],
                    [
                        'question' => 'When will I be charged?',
                        'answer' => 'You will be charged immediately upon completing your booking. For accommodation bookings, you may be charged according to the accommodation\'s payment policy.'
                    ]
                ]
            ]
        ];

        return view('public.help.index', compact('faqs'));
    }

    public function contact()
    {
        return view('public.help.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Here you would typically send an email or store the contact form submission
        // For now, we'll just return a success message

        return redirect()->route('public.help.contact')->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }
}
