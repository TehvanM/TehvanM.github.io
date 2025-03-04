<?php
// Simple PHP functionality for form handling
$formSubmitted = false;
$formError = false;
$errorMessage = '';

// Process contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic validation
    if (empty($_POST['email'])) {
        $formError = true;
        $errorMessage = 'Email is required';
    } else {
        $formSubmitted = true;
        // In a real application, you would process the form data here
        // For example, send an email or store in database
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Key to your Motivation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles */
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1541140532154-b024d705b90a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0;
            text-align: center;
            position: relative;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .section-title {
            margin-bottom: 40px;
            text-align: center;
        }
        
        .card {
            margin-bottom: 30px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }
        
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .team-member img {
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .social-icons a {
            margin: 0 5px;
            color: #007bff;
        }
        
        .cta-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            text-align: center;
        }
        
        .contact-section {
            padding: 60px 0;
        }
        
        .map-container {
            height: 500px;
            width: 100%;
        }
        
        footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
        }
        
        .footer-links a {
            color: white;
            margin: 0 10px;
        }
        
        .placeholder-box {
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            height: 100%;
            min-height: 200px;
        }
        
        .blueprint-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .blueprint-box {
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .blueprint-box-large {
            height: 300px;
        }
        
        .blueprint-box-medium {
            height: 250px;
        }
        
        .blueprint-box-small {
            height: 200px;
        }
        
        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 24px;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-20px) translateX(-50%);
            }
            60% {
                transform: translateY(-10px) translateX(-50%);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">KT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#blueprints">Blueprints</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="#contact" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container hero-content">
            <h1 class="display-4 fw-bold">The Key to your Motivation</h1>
            <p class="lead">Learn, Think, Grow, Evolve, Apply</p>
            <a href="#features" class="btn btn-warning btn-lg mt-3">Get Started Now</a>
            <div class="scroll-down">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="section-title">Carousel cards title</h2>
            <div id="featureCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <img src="https://images.unsplash.com/photo-1414609245224-afa02bfb3fda?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1936&q=80" class="card-img-top" alt="Beach sunset">
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <img src="https://images.unsplash.com/photo-1519834785169-98be25ec3f84?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1964&q=80" class="card-img-top" alt="Hot air balloon">
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <img src="https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80" class="card-img-top" alt="Night sky">
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featureCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featureCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Blueprints Section -->
    <section id="blueprints" class="blueprint-section">
        <div class="container">
            <h2 class="section-title">Blueprints</h2>
            <p class="text-center mb-5">Focus display, define as custom community, better source confirmation ratio, all foundation media plan.</p>
            
            <!-- First row: Two large blueprints -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="blueprint-box blueprint-box-large">
                        <h3>600 x 300</h3>
                    </div>
                    <p>Focus display, define as custom community, better source confirmation ratio, all foundation media plan.</p>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="blueprint-box blueprint-box-large">
                        <h3>600 x 300</h3>
                    </div>
                    <p>Focus display, define as custom community, better source confirmation ratio, all foundation media plan.</p>
                </div>
            </div>
            
            <!-- Second row: 2x2 grid of blueprints -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="blueprint-box blueprint-box-medium">
                                <h3>1170 x 700</h3>
                            </div>
                            <h5 class="mt-3">Blueprints</h5>
                            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="blueprint-box blueprint-box-medium">
                                <h3>1170 x 700</h3>
                            </div>
                            <h5 class="mt-3">Blueprints</h5>
                            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="blueprint-box blueprint-box-medium">
                                <h3>1170 x 700</h3>
                            </div>
                            <h5 class="mt-3">Blueprints</h5>
                            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="blueprint-box blueprint-box-medium">
                                <h3>1170 x 700</h3>
                            </div>
                            <h5 class="mt-3">Blueprints</h5>
                            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-8 mb-4">
                    <h3>Blueprints</h3>
                    <p>Focus display, define as custom community, better source confirmation ratio, all foundation media plan.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blueprint-box blueprint-box-medium">
                        <h3>600 x 300</h3>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <div class="blueprint-box blueprint-box-medium">
                        <h3>600 x 600</h3>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <h3>Wireframes</h3>
                    <p>Focus display, define as custom community, better source confirmation ratio, all foundation media plan for a comprehensive style for all areas of the business.</p>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5>Open Source</h5>
                            <p>Focus display, define as custom community, better source confirmation ratio.</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Bootstrap</h5>
                            <p>Focus display, define as custom community, better source confirmation ratio.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h3>Your Website</h3>
                    <p>Focus on confirmation ratio, all foundation media plan, all foundation media.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Amazing Design</h3>
                    <p>Better source confirmation ratio, all foundation media plan, all foundation design.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blueprint-box blueprint-box-medium">
                        <h3>1170 x 700</h3>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="blueprint-box blueprint-box-small">
                        <h3>1170 x 700</h3>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="blueprint-box blueprint-box-small">
                        <h3>1170 x 700</h3>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <p>Focus display, define as custom community, better source confirmation ratio, all foundation media plan.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-5">
        <div class="container">
            <h2 class="section-title">Our Team</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="team-member">
                        <div class="blueprint-box blueprint-box-small">
                            <h3>250 x 250</h3>
                        </div>
                        <h4>Jane Doe</h4>
                        <p>CEO & Founder</p>
                        <p>She joined the company in 2015 and has been instrumental in growing the business to what it is today.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-member">
                        <div class="blueprint-box blueprint-box-small">
                            <h3>250 x 250</h3>
                        </div>
                        <h4>John Doe</h4>
                        <p>CTO</p>
                        <p>He joined the company in 2016 and has been instrumental in developing the technology that powers our platform.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-member">
                        <div class="blueprint-box blueprint-box-small">
                            <h3>250 x 250</h3>
                        </div>
                        <h4>Jane Doe</h4>
                        <p>Designer</p>
                        <p>She joined the company in 2017 and has been instrumental in creating the beautiful designs that our customers love.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-member">
                        <div class="blueprint-box blueprint-box-small">
                            <h3>250 x 250</h3>
                        </div>
                        <h4>John Doe</h4>
                        <p>Developer</p>
                        <p>He joined the company in 2018 and has been instrumental in building the robust backend that powers our platform.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="mb-4">CALL TO ACTION HEADLINE</h2>
            <p class="mb-4">Call to action text. This is some text and button within a call-to-action text block.</p>
            <a href="#contact" class="btn btn-danger btn-lg">Call To Action Button</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <p class="text-center mb-5">If you already decided, we invite you to join us by contacting us.</p>
            
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <?php if ($formSubmitted): ?>
                        <div class="alert alert-success">
                            Thank you for your message! We will get back to you soon.
                        </div>
                    <?php else: ?>
                        <?php if ($formError): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#contact">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">How can we help?</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Map Container - Moved to bottom of contact section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.3059353029!2d-74.25986548248684!3d40.69714941932609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1619528783621!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?php echo date('Y'); ?> The Key to your Motivation. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="footer-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70, // Adjust for fixed navbar
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Form validation using Bootstrap
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>