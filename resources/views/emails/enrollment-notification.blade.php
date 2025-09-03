<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Enrollment Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            background-color: #f8f9fa;
        }
        .container {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .header {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header .subtitle {
            color: rgba(255, 255, 255, 0.8);
            margin: 10px 0 0;
            font-size: 16px;
        }
        .alert-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 15px;
        }
        .content {
            padding: 40px;
            background: rgba(255, 255, 255, 0.03);
            color: #ffffff;
        }
        .course-header {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .course-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 15px;
        }
        .course-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .stat-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
        }
        .trainee-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #4f46e5;
        }
        .section-title {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 20px;
            display: flex;
            align-items: center;
        }
        .section-title svg {
            margin-right: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .info-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .info-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .info-value {
            color: #ffffff;
            font-weight: 500;
            font-size: 15px;
        }
        .experience-section {
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .experience-text {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            font-style: italic;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            min-width: 140px;
            display: inline-block;
        }
        .btn-approve {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .btn-view {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        .enrollment-id {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #ffffff;
            display: inline-block;
            margin: 10px 0;
        }
        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        .footer {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .footer p {
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 0;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            .course-stats {
                grid-template-columns: 1fr 1fr;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 New Enrollment Alert</h1>
            <p class="subtitle">AMEX Training Institute - Admin Dashboard</p>
            <div class="alert-badge">New Application Received</div>
        </div>

        <div class="content">
            <div class="course-header">
                <div class="course-title">{{ $course->title }}</div>
                <div class="enrollment-id">Enrollment ID: #ENR-{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div style="margin-top: 15px;">
                    <span class="status-pending">{{ ucfirst($enrollment->status) }}</span>
                    <span style="color: rgba(255, 255, 255, 0.7); margin-left: 15px;">
                        Submitted: {{ $enrollment->formatted_enrollment_date }}
                    </span>
                </div>

                <div class="course-stats">
                    <div class="stat-item">
                        <div class="stat-value">${{ number_format($course->price, 0) }}</div>
                        <div class="stat-label">Course Price</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $course->duration_weeks }}</div>
                        <div class="stat-label">Weeks</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $course->max_participants }}</div>
                        <div class="stat-label">Max Students</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $course->enrollments()->approved()->count() }}</div>
                        <div class="stat-label">Current Enrolled</div>
                    </div>
                </div>
            </div>

            <div class="trainee-info">
                <h3 class="section-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Applicant Information
                </h3>

                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $enrollment->trainee_name }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $enrollment->trainee_email }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $enrollment->trainee_phone }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Age</div>
                        <div class="info-value">{{ $enrollment->age }} years old</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Gender</div>
                        <div class="info-value">{{ ucfirst($enrollment->gender) }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Education Level</div>
                        <div class="info-value">{{ $enrollment->education_level }}</div>
                    </div>
                </div>

                <div class="info-card" style="margin-top: 20px;">
                    <div class="info-label">Complete Address</div>
                    <div class="info-value">{{ $enrollment->trainee_address }}</div>
                </div>

                @if($enrollment->previous_experience)
                <div class="experience-section">
                    <div class="info-label">Previous Experience</div>
                    <div class="experience-text">{{ $enrollment->previous_experience }}</div>
                </div>
                @endif
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn btn-view">
                    👁️ View Details
                </a>
                <a href="{{ route('admin.enrollments.approve', $enrollment) }}" class="btn btn-approve">
                    ✅ Approve
                </a>
                <a href="{{ route('admin.enrollments.reject', $enrollment) }}" class="btn btn-reject">
                    ❌ Reject
                </a>
            </div>

            <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h4 style="color: #3b82f6; margin: 0 0 10px;">📋 Quick Actions Needed:</h4>
                <ul style="color: rgba(255, 255, 255, 0.9); margin: 0; padding-left: 20px;">
                    <li>Review the applicant's qualifications and experience</li>
                    <li>Verify contact information and education level</li>
                    <li>Check course capacity ({{ $course->enrollments()->approved()->count() }}/{{ $course->max_participants }} enrolled)</li>
                    <li>Process enrollment approval or rejection within 2-3 business days</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p><strong>AMEX Training Institute</strong> - Admin Panel</p>
            <p>📧 admin@amextraining.com | 📞 +1 (555) 123-4567</p>
            <p>&copy; {{ date('Y') }} AMEX Training Institute. All rights reserved.</p>
            <p style="font-size: 12px; color: rgba(255, 255, 255, 0.5);">
                This is an automated notification. Please log in to the admin panel to take action.
            </p>
        </div>
    </div>
</body>
</html>