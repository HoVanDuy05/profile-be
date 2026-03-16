<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;

class CVDataSeeder extends Seeder
{
    public function run(): void
    {
        // Profile
        Profile::create([
            'name' => 'Hồ Văn Duy',
            'title' => 'Junior Full-stack Developer',
            'email' => 'vanduyho717@gmail.com',
            'phone' => '0372 002 972',
            'location' => 'Thành phố Hồ Chí Minh',
            'education' => 'Cao đẳng FPT Polytechnic',
            'bio' => 'Tôi là một lập trình viên Full-stack trẻ tuổi với niềm đam mê mãnh liệt trong việc tạo ra những sản phẩm web chất lượng cao, tối ưu và hướng tới người tiêu dùng.',
            'avatar' => '/assets/images/profile.jpg',
            'linkedin' => 'https://linkedin.com/in/vanduydev',
            'github' => 'https://github.com/vanduydev',
            'experience_years' => '1',
            'projects_count' => '10+',
            'clients_count' => '5+',
        ]);

        // Skills
        $skills = [
            ['name' => 'React / Next.js', 'level' => 95, 'category' => 'technical'],
            ['name' => 'Node.js / Express', 'level' => 90, 'category' => 'technical'],
            ['name' => 'TypeScript', 'level' => 85, 'category' => 'technical'],
            ['name' => 'PHP / Laravel', 'level' => 85, 'category' => 'technical'],
            ['name' => 'PostgreSQL / MongoDB', 'level' => 85, 'category' => 'technical'],
            ['name' => 'MySQL / Redis', 'level' => 80, 'category' => 'technical'],
            ['name' => 'Tiếng Việt (Bản ngữ)', 'level' => 100, 'category' => 'language'],
            ['name' => 'Tiếng Anh (IELTS 7.5)', 'level' => 75, 'category' => 'language'],
            ['name' => 'Tiếng Nhật (N3)', 'level' => 60, 'category' => 'language'],
            ['name' => 'Git', 'level' => 90, 'category' => 'other'],
            ['name' => 'Agile/Scrum', 'level' => 85, 'category' => 'other'],
            ['name' => 'Figma', 'level' => 70, 'category' => 'other'],
            ['name' => 'Problem Solving', 'level' => 85, 'category' => 'other'],
            ['name' => 'Team Leadership', 'level' => 75, 'category' => 'other'],
        ];
        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Experiences
        Experience::create([
            'title' => 'Junior Fullstack Developer',
            'company' => 'Freelance / Personal Projects',
            'period' => '2023 - Present',
            'description' => 'Phát triển các ứng dụng web hiện đại sử dụng React, Node.js và Laravel. Tập trung vào tối ưu hóa mã nguồn và trải nghiệm người dùng.',
            'type' => 'work',
        ]);

        Experience::create([
            'title' => 'Lập trình Web (Full-stack)',
            'company' => 'Cao đẳng FPT Polytechnic',
            'period' => '2024 - 2026',
            'description' => 'Chuyên ngành Phát triển phần mềm, tập trung vào các công nghệ web hiện đại và quy trình phát triển sản phẩm thực tế.',
            'type' => 'edu',
        ]);

        // Projects
        $projects = [
            [
                'title' => 'Hệ thống Quản lý Doanh nghiệp',
                'subtitle' => 'ERP Platform',
                'description' => 'Nền tảng ERP tích hợp quản lý kho, nhân sự và tài chính.',
                'tags' => ['React', 'Node.js', 'PostgreSQL'],
                'image' => '/assets/images/project1.png',
                'demo_link' => '#',
                'github_link' => '#',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Ứng dụng E-Learning',
                'subtitle' => 'Online Learning',
                'description' => 'Hệ thống học trực tuyến với tính năng video streaming và thi trắc nghiệm.',
                'tags' => ['Next.js', 'Firebase', 'Tailwind'],
                'image' => '/assets/images/project2.png',
                'demo_link' => '#',
                'github_link' => '#',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Sàn Thương mại Điện tử',
                'subtitle' => 'E-commerce API',
                'description' => 'Nền tảng mua sắm với trải nghiệm mượt mà, hỗ trợ thanh toán online.',
                'tags' => ['React Native', 'Shopify API', 'Vite'],
                'image' => '/assets/images/project3.png',
                'demo_link' => '#',
                'github_link' => '#',
                'is_featured' => false,
                'sort_order' => 3,
            ],
        ];
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
