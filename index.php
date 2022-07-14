<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Facebook meta tags -->
    <meta property="og:title" content="Kier Asis" />
    <meta property="og:url" content="https://kierasis.me/" />
    <meta property="og:image" content="https://kierasis.me/og_fb.png" />
    <meta property="og:description" content="Hi! I am Kier Asis." />

    <!-- Twitter meta tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Kier Asis" />
    <meta name="twitter:description" content="Hi! I am Kier Asis." />
    <meta name="twitter:image" content="https://kierasis.me/og_fb.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css"
        integrity="sha384-3B6NwesSXE7YJlcLI9RpRqGf2p/EgVH8BgoKTaUrmKNDkHPStTQ3EyoYjCGXaOTS" crossorigin="anonymous" />
    <title>Kier Asis | Website</title>
    <style>
    .iam {
        color: white;
        font-size: 55px;
        font-family: sans-serif;
    }

    .wrap {
        color: white;
        border-right: 2px solid rgb(62, 216, 255);
        font-size: 55px;
        font-family: sans-serif;
        color: rgb(62, 216, 255);
    }

    .kier-img {
        width: 100%;
    }

    @media (max-width: 576px) {
        .iam {
            font-size: 40px;
        }

        .wrap {
            font-size: 35px;
        }

    }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
</head>

<body style="background-color: #24252f;">
    <!-- Page Content-->
    <section class="bg-secondary">
        <div class="container px-4 px-lg-6 text-center">
            <div class="row  align-items-center">
                <!-- Footer Location-->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="asis.png" class="kier-img rounded mx-auto d-block" alt="...">
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="container">
                        <div class="row  justify-content-md-center">
                            <div class="col-md-auto iam">I am</div>
                            <div class="col-md-auto typewrite" data-period="2000"
                                data-type='[ "Kier Asis.", "Student.", "Programmer." ]'>
                                <span class="wrap"></span>
                            </div>
                        </div>
                    </div>
                    </h1>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://web.facebook.com/kierxx08/"><i
                            class="fa-brands fa-facebook-square fa-xl"></i></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://twitter.com/kierxx08"><i
                            class="fa-brands fa-twitter-square fa-xl"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/kierxx08"><i
                            class="fa-brands fa-linkedin fa-xl"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://github.com/kierxx08"><i
                            class="fa-brands fa-github fa-xl"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="mailto:email@kierasis.me"><i
                            class="fa-solid fa-at fa-xl"></i></a>
                </div>
            </div>
        </div>
    </section>
    <script>
    //made by vipul mirajkar thevipulm.appspot.com
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) {
            delta /= 2;
        }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #3ed8ff}";
        document.body.appendChild(css);
    };
    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>