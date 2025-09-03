<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background: #ffffff;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #000;
            font-size: 24px;
        }
        
        .email-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .email-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .reference-id-banner {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
        }
        
        .reference-id-banner .ref-id {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 5px;
            font-family: monospace;
        }
        
        .email-content {
            padding: 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .course-info {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .course-info h3 {
            color: #007bff;
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }
        
        .info-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .materials-section {
            margin: 30px 0;
        }
        
        .materials-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        
        .icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            opacity: 0.7;
        }
        
        .materials-list {
            background: #e8f4f8;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
        }
        
        .materials-list ul {
            list-style: none;
        }
        
        .materials-list li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        
        .materials-list li:last-child {
            border-bottom: none;
        }
        
        .materials-list li::before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
            width: 16px;
        }
        
        .next-steps {
            margin: 30px 0;
        }
        
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .step-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-weight: bold;
            font-size: 18px;
        }
        
        .step-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .step-description {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
            padding: 30px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 12px;
            color: white;
        }
        
        .cta-button {
            display: inline-block;
            background: white;
            color: #007bff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 15px 10px;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .cta-button.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .footer {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 30px;
            text-align: center;
        }
        
        .footer h4 {
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .contact-item a {
            color: #3498db;
            text-decoration: none;
        }
        
        .contact-item a:hover {
            text-decoration: underline;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #3498db;
            text-decoration: none;
        }
        
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .warning-box h4 {
            margin-bottom: 10px;
            color: #b45309;
        }
        
        @media (max-width: 600px) {
            .email-content {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .steps-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                grid-template-columns: 1fr;
            }
            
            .cta-button {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo">A</div>
            <h1>AMEX Training Institute</h1>
            <p>Course Enrollment Confirmation</p>
        </div>
        
        <!-- Reference ID Banner -->
        <div class="reference-id-banner">
            <div>Your Reference ID</div>
            <div class="ref-id">{{ $referenceId }}</div>
        </div>
        
        <!-- Main Content -->
        <div class="email-content">
            <div class="greeting">
                Dear {{ $studentName }},
            </div>
            
            <p>Congratulations! Your enrollment application for <strong>{{ $course->title }}</strong> has been successfully submitted and confirmed.</p>
            
            <!-- Course Information -->
            <div class="course-info">
                <h3>📚 Course Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Course Title</div>
                        <div class="info-value">{{ $course->title }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Duration</div>
                        <div class="info-value">{{ $courseMaterials['duration'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Instructor</div>
                        <div class="info-value">{{ $course->lecturer_name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Course Fee</div>
                        <div class="info-value">${{ number_format($course->price, 0) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Start Date</div>
                        <div class="info-value">{{ $courseMaterials['startDate'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Platform</div>
                        <div class="info-value">{{ $courseMaterials['platform'] }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Course Materials -->
            <div class="materials-section">
                <h3>📖 Course Materials & Resources</h3>
                
                <div class="materials-list">
                    <h4 style="margin-bottom: 15px; color: #007bff;">Course Materials:</h4>
                    <ul>
                        @foreach($courseMaterials['materials'] as $material)
                        <li>{{ $material }}</li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="materials-list">
                    <h4 style="margin-bottom: 15px; color: #007bff;">Additional Resources:</h4>
                    <ul>
                        @foreach($courseMaterials['resources'] as $resource)
                        <li>{{ $resource }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Next Steps -->
            <div class="next-steps">
                <h3>🎯 Next Steps</h3>
                <div class="steps-grid">
                    @foreach($nextSteps as $index => $step)
                    <div class="step-card">
                        <div class="step-number">{{ $index + 1 }}</div>
                        <div class="step-title">{{ $step['title'] }}</div>
                        <div class="step-description">{{ $step['description'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="warning-box">
                <h4>⚠️ Important Information</h4>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>Keep your Reference ID (<strong>{{ $referenceId }}</strong>) safe - you'll need it to access your course</li>
                    <li>Check your email regularly for updates and course communications</li>
                    <li>No payment is required until your application is approved</li>
                    <li>Applications are reviewed within 2-3 business hours</li>
                </ul>
            </div>
            
            <!-- Call to Action -->
            <div class="cta-section">
                <h3 style="margin-bottom: 15px;">Ready to Get Started?</h3>
                <p style="margin-bottom: 20px;">Access your course dashboard and track your enrollment progress.</p>
                <a href="{{ $dashboardUrl }}" class="cta-button">Access Dashboard</a>
                <a href="mailto:{{ $supportEmail }}" class="cta-button secondary">Contact Support</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h4>Need Help?</h4>
            <div class="contact-info">
                <div class="contact-item">
                    📧 <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                </div>
                <div class="contact-item">
                    📞 <a href="tel:+15551234567">+1 (555) 123-4567</a>
                </div>
                <div class="contact-item">
                    🌐 <a href="#">www.amextraining.com</a>
                </div>
            </div>
            
            <div class="social-links">
                <a href="#">LinkedIn</a>
                <a href="#">Twitter</a>
                <a href="#">Facebook</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; opacity: 0.8;">
                © {{ date('Y') }} AMEX Training Institute. All rights reserved.<br>
                This email was sent to {{ $enrollment->trainee_email }} regarding your enrollment in {{ $course->title }}.
            </p>
        </div>
    </div>
</body>
</html>