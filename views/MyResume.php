<?php

use yii\helpers\Html;
use app\models\Gallery;
use app\assets\MyResumeAsset;
use app\components\Data;

$data = new Data([
    'data' => $data,
]);

MyResumeAsset::register($this);
$this->title = $data->cell('user', 'profile', 'header');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="<?= Gallery::getUrl('favicon.svg') ?>" type="image/svg+xml">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- ======= Mobile nav toggle button ======= -->
    <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex flex-column justify-content-center">

        <nav class="nav-menu">
            <ul>
                <li class="active"><a href="#hero"><i class="bx bx-home"></i> <span>Home</span></a></li>
                <li><a href="#about"><i class="bx bx-user"></i> <span>About</span></a></li>
                <li><a href="#resume"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
                <li><a href="#portfolio"><i class="bx bx-book-content"></i> <span>Portfolio</span></a></li>
                <li><a href="#testimonials"><i class="bx bx-server"></i> <span>Testimonials</span></a></li>
                <li><a href="#contact"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center" style="background: url('<?= Gallery::getUrl($data->cell('about', 'banner', 'gallery_name'))  ?>') no-repeat; background-size:cover;">
        <div class="container" data-aos="zoom-in" data-aos-delay="100">
            <h1><?= $data->cell('user', 'profile', 'header') ?></h1>
            <p>I'm <span class="typed" data-typed-items="<?= $data->cell('about', 'banner', 'body') ?>"></span></p>
            <div class="social-links">
                <?php
                if ($data->cell('social', 'twitter', 'body')) {
                    echo '<a href="' . $data->cell('social', 'twitter', 'body') . '" class="twitter"><i class="bx bxl-twitter"></i></a>';
                }
                if ($data->cell('social', 'facebook', 'body')) {
                    echo '<a href="' . $data->cell('social', 'facebook', 'body') . '" class="facebook"><i class="bx bxl-facebook"></i></a>';
                }
                if ($data->cell('social', 'instagram', 'body')) {
                    echo '<a href="' . $data->cell('social', 'instagram', 'body') . '" class="instagram"><i class="bx bxl-instagram"></i></a>';
                }
                if ($data->cell('social', 'linkedin', 'body')) {
                    echo '<a href="' . $data->cell('social', 'linkedin', 'body') . '" class="linkedin"><i class="bx bxl-linkedin"></i></a>';
                }
                ?>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About</h2>
                    <p><?= $data->cell('user', 'profile', 'body') ?></p>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <img src="<?= Gallery::getUrl($data->cell('user', 'profile', 'gallery_name')) ?>" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8 pt-4 pt-lg-0 content">
                        <h3><?= $data->cell('about', 'description', 'header') ?></h3>
                        <p class="font-italic"><?= $data->cell('about', 'description', 'body') ?></p>

                        <div class="row">

                            <?php
                            $aboutItems = $data->all('about', 'items');
                            $aboutItemLen = count($aboutItems);

                            foreach ([
                                array_slice($aboutItems, 0, $aboutItemLen / 2 + 1),
                                array_slice($aboutItems, $aboutItemLen / 2 + 1),
                            ] as $aboutHalfItems) {
                                echo '<div class="col-lg-6"><ul>';
                                foreach ($aboutHalfItems as $aboutItem) { ?>
                                    <li><i class="icofont-rounded-right"></i> <strong><?= $aboutItem['header'] ?>:</strong> <?= $aboutItem['body'] ?></li>
                            <?php }
                                echo '</ul></div>';
                            }
                            ?>

                        </div>


                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <?php if ($skills = $data->count('skill')) { ?>
            <!-- ======= Skills Section ======= -->
            <section id="skills" class="skills section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Skills</h2>
                        <p><?= $data->cell('skill', 'description', 'body') ?></p>
                    </div>

                    <div class="row skills-content">

                        <?php
                        $skillItems = $data->all('skill', 'items');
                        $skillItemLen = count($skillItems);

                        foreach ([
                            array_slice($skillItems, 0, $skillItemLen / 2),
                            array_slice($skillItems, $skillItemLen / 2),
                        ] as $skillHalfItems) {
                            echo '<div class="col-lg-6">';
                            foreach ($skillHalfItems as $skillItem) { ?>
                                <div class="progress">
                                    <span class="skill"><?= $skillItem['header'] ?> <i class="val"><?= $skillItem['tag'] ?>%</i></span>
                                    <div class="progress-bar-wrap">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= $skillItem['tag'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                        <?php }
                            echo '</div>';
                        }
                        ?>

                    </div>

                </div>
            </section><!-- End Skills Section -->
        <?php } ?>

        <?php if ($resumes = $data->count('resume')) { ?>
            <!-- ======= Resume Section ======= -->
            <section id="resume" class="resume">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Resume</h2>
                        <p><?= $data->cell('resume', 'description', 'body') ?></p>
                    </div>

                    <div class="row">
                        <div class="col-lg-10">
                            <?php foreach (['summary', 'education', 'experience'] as $resumeKey) {
                                echo '<h3 class="resume-title">' . ucfirst($resumeKey) . '</h3>';
                                foreach ($data->all('resume', $resumeKey) as $resume) { ?>
                                    <div class="resume-item">
                                        <?= $resume['header'] ? '<h4>' . $resume['header']  . '</h4>' : '' ?>
                                        <?= $resume['tag'] ? '<h5>' . $resume['tag']  . '</h5>' : '' ?>
                                        <?= $resume['body'] ? '<p>' . $resume['body']  . '</p>' : '' ?>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </section><!-- End Resume Section -->
        <?php } ?>

        <?php if ($portfolios = $data->count('portfolio')) { ?>
            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Portfolio</h2>
                        <p><?= $data->cell('portfolio', 'description', 'body') ?></p>
                    </div>

                    <?php
                    if ($portfoliosItems = $data->all('portfolio', 'items')) {
                        $portfoliosTags = [];
                        foreach ($portfoliosItems as $portfoliosItem) {
                            $portfoliosTags[$portfoliosItem['tag']] = hash('sha256', $portfoliosItem['tag']);
                        }
                    ?>
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                                <ul id="portfolio-flters">
                                    <li data-filter="*" class="filter-active">All</li>
                                    <?php
                                    foreach ($portfoliosTags as $portfolioTag => $portfolioTagHash) {
                                        echo '<li data-filter=".' . $portfolioTagHash . '">' . $portfolioTag . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                            <?php foreach ($portfoliosItems as $portfoliosItem) {
                                $galleryUrl = Gallery::getUrl($portfoliosItem['gallery_name']);
                            ?>
                                <div class="col-lg-4 col-md-6 portfolio-item <?= $portfoliosTags[$portfoliosItem['tag']] ?>">
                                    <div class="portfolio-wrap">
                                        <img src="<?= $galleryUrl ?>" class="img-fluid" alt="">
                                        <div class="portfolio-info">
                                            <h4><?= $portfoliosItem['header'] ?></h4>
                                            <p><?= $portfoliosItem['body'] ?></p>
                                            <div class="portfolio-links">
                                                <a href="<?= $galleryUrl ?>" data-gall="portfolioGallery" class="venobox" title="<?= $portfoliosItem['header'] ?>"><i class="bx bx-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>
            </section><!-- End Portfolio Section -->
        <?php } ?>


        <?php if ($testimonials = $data->all('testimonial', 'items')) { ?>

            <!-- ======= Testimonials Section ======= -->
            <section id="testimonials" class="testimonials section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Testimonials</h2>
                    </div>

                    <div class="owl-carousel testimonials-carousel" data-aos="zoom-in" data-aos-delay="100">

                        <?php foreach ($testimonials as $testimonial) { ?>
                            <div class="testimonial-item">
                                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                                <h3><?= $testimonial['header'] ?></h3>
                                <h4><?= $testimonial['tag'] ?></h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    <?= $testimonial['body'] ?>
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        <?php } ?>

                    </div>

                </div>
            </section><!-- End Testimonials Section -->
        <?php } ?>


        <?php if ($contactCount = $data->count('contact')) { ?>

            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Contact</h2>
                    </div>

                    <div class="row mt-1">
                        <?php if ($data->cell('contact', 'location', 'body')) { ?>
                            <div class="col-lg-<?= intval(12 / $contactCount) ?> info">
                                <div class="address" style="margin-top: 0;">
                                    <i class="icofont-google-map"></i>
                                    <h4>Location:</h4>
                                    <p><?= $data->cell('contact', 'location', 'body'); ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($data->cell('contact', 'email', 'body')) { ?>
                            <div class="col-lg-<?= intval(12 / $contactCount) ?> info">
                                <div class="email" style="margin-top: 0;">
                                    <i class="icofont-envelope"></i>
                                    <h4>Email:</h4>
                                    <p><?= $data->cell('contact', 'email', 'body'); ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($data->cell('contact', 'call', 'body')) { ?>
                            <div class="col-lg-<?= intval(12 / $contactCount) ?> info">
                                <div class="phone" style="margin-top: 0;">
                                    <i class="icofont-phone"></i>
                                    <h4>Call:</h4>
                                    <p><?= $data->cell('contact', 'call', 'body'); ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </section><!-- End Contact Section -->
        <?php } ?>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <h3><?= $data->cell('about', 'footer', 'header') ?></h3>
            <p><?= $data->cell('about', 'footer', 'body') ?></p>
            <div class="social-links">
                <?php
                if ($data->cell('social', 'twitter', 'body')) {
                    echo '<a href="' . $data->cell('social', 'twitter', 'body') . '" class="twitter"><i class="bx bxl-twitter"></i></a>';
                }
                if ($data->cell('social', 'facebook', 'body')) {
                    echo '<a href="' . $data->cell('social', 'facebook', 'body') . '" class="facebook"><i class="bx bxl-facebook"></i></a>';
                }
                if ($data->cell('social', 'instagram', 'body')) {
                    echo '<a href="' . $data->cell('social', 'instagram', 'body') . '" class="instagram"><i class="bx bxl-instagram"></i></a>';
                }
                if ($data->cell('social', 'linkedin', 'body')) {
                    echo '<a href="' . $data->cell('social', 'linkedin', 'body') . '" class="linkedin"><i class="bx bxl-linkedin"></i></a>';
                }
                ?>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
    <div id="preloader"></div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>