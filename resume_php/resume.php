<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Personal information
$name = "DANIEL B. VILLANUEVA";
$location = "Bagong Pook, Rosario, Batangas";
$phone = "0927-164-6563";
$email = "danielbvillanueva12@gmail.com";

// Objective statement
$objective = "Motivated Computer Science student seeking a remote opportunity to develop practical skills in web and mobile development, data handling, and IT-related tasks. While I have no professional work experience yet, I am eager to learn, detail-oriented, and adaptable.";

// Skills arrays
$programming_skills = array("Python", "JavaScript", "C#");
$web_skills = array("HTML", "CSS", "React");
$mobile_skills = array("Flutter");
$database_skills = array("MySQL", "Postgresql", "Firebase");
$tool_skills = array("Git", "GitHub", "VS Code", "Figma");

// Education
$school = "Batangas State University";
$degree = "Bachelor of Science in Computer Science";
$graduation = "Expected Graduation: June 2027";
$school_location = "Batangas, Philippines";

// Organizations
$org1 = "Junior Philippine Computer Society (JPCS) – Member";
$org2 = "Association of Committed Computer Science Students (ACCESS) – Member";

// Projects
$project_title = "Crop Monitoring Website (School Project)";
$project_point1 = "Assisted in gathering and organizing sample agricultural data.";
$project_point2 = "Developed a simple website for crop tracking using HTML, CSS, and JavaScript.";
$project_point3 = "Contributed to documentation, data presentation, and layout design.";
$project_tech = "HTML, CSS, JavaScript";

// Practical experience
$exp1 = "Collaborated on academic projects involving data collection, cleaning, and organization.";
$exp2 = "Participated in web development projects using HTML, CSS, and JavaScript.";
$exp3 = "Completed online courses in Python programming and web development.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .resume {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3498db;
        }
        .name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 10px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .email {
            color: #2980b9;
            text-decoration: none;
        }
        .email:hover {
            text-decoration: underline;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 20px;
            color: #2c3e50;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .skill-category {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .skill-category-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #ddd;
        }
        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .skill {
            background: #e8f4fc;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            color: #2c3e50;
        }
        
        .education-item {
            margin-bottom: 15px;
        }
        .school {
            font-weight: bold;
            color: #2c3e50;
        }
        .project {
            margin-bottom: 20px;
        }
        .project-title {
            font-weight: bold;
            color: #2c3e50;
        }
        .project-tech {
            font-style: italic;
            color: #7f8c8d;
            margin: 5px 0;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 8px;
        }
        
        .logout-container {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .logout-btn {
            display: inline-block;
            width: 120px;
            padding: 10px 15px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .resume {
                box-shadow: none;
                padding: 0;
            }
            .logout-container {
                display: none;
            }
        }
        @media (max-width: 600px) {
            .skills-grid {
                grid-template-columns: 1fr;
            }
            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="resume">
        <div class="header">
            <div class="name"><?php echo $name; ?></div>
            <div class="contact-info">
                <div class="contact-item"><?php echo $location; ?></div>
                <div class="contact-item"><?php echo $phone; ?></div>
                <div class="contact-item">
                    <a class="email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Career Objective</div>
            <p><?php echo $objective; ?></p>
        </div>

        <div class="section">
            <div class="section-title">Technical Skills</div>
            <div class="skills-grid">
                <div class="skill-category">
                    <div class="skill-category-title">Programming Languages</div>
                    <div class="skill-list">
                        <?php foreach ($programming_skills as $skill): ?>
                            <div class="skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Web Development</div>
                    <div class="skill-list">
                        <?php foreach ($web_skills as $skill): ?>
                            <div class="skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Mobile Development</div>
                    <div class="skill-list">
                        <?php foreach ($mobile_skills as $skill): ?>
                            <div class="skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Databases</div>
                    <div class="skill-list">
                        <?php foreach ($database_skills as $skill): ?>
                            <div class="skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Tools</div>
                    <div class="skill-list">
                        <?php foreach ($tool_skills as $skill): ?>
                            <div class="skill"><?php echo $skill; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Projects & Experience</div>
            <div class="project">
                <div class="project-title"><?php echo $project_title; ?></div>
                <div class="project-tech">Technologies: <?php echo $project_tech; ?></div>
                <ul>
                    <li><?php echo $project_point1; ?></li>
                    <li><?php echo $project_point2; ?></li>
                    <li><?php echo $project_point3; ?></li>
                </ul>
            </div>
            <div class="project">
                <div class="project-title">Additional Practical Experience</div>
                <ul>
                    <li><?php echo $exp1; ?></li>
                    <li><?php echo $exp2; ?></li>
                    <li><?php echo $exp3; ?></li>
                </ul>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Education</div>
            <div class="education-item">
                <div class="school"><?php echo $school; ?></div>
                <div><?php echo $degree; ?></div>
                <div><?php echo $graduation; ?></div>
                <div><?php echo $school_location; ?></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Organizations</div>
            <ul>
                <li><?php echo $org1; ?></li>
                <li><?php echo $org2; ?></li>
            </ul>
        </div>

        <div class="logout-container">
            <a href="login_signup.php?logout=true" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>