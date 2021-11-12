<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package OceanWP WordPress theme
 */
get_header();
?>

<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri()?>/custom.css">
</head>

	    <section id="primary" class="content-area">
		<main id="main" class="site-main">

        <button>Tilbage</button>

        <article id="artikel">
        <img class="pic" src="" alt="" />
        <div>
        <h2></h2>
        <p class="beskrivelse"></p>
        <p class="fag"></p>
        </div>
        </article>

        </main><!-- #main -->

        <script>

        let kursus;
		const url = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/kursus/"+<?php echo get_the_ID() ?>;

		async function getJson() {
        console.log("id er", <?php echo get_the_ID() ?>);
  		const response = await fetch(url);
  		kursus = await response.json();
        console.log(kursus);
  		visKursus();
    
		}

        function visKursus() {
            document.querySelector("h2").textContent = kursus.title.rendered;
            document.querySelector(".pic").src = kursus.billede.guid;
            document.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
            document.querySelector(".fag").textContent = kursus.fag;
        }

        getJson ();

        document.querySelector("button").addEventListener("click", () => {
        window.history.back();
      });

        </script>

		
	</section><!-- #primary -->

<?php
get_footer();
