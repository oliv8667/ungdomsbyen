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
		<main id="main-single" class="site-main">

        <button class="tilbageknap_single">Tilbage</button>

        <article id="artikel_single">
        <img class="pic_single" src="" alt="" />
        <div>
        <h2 class="titel_single"></h2>
        <p class="langbeskrivelse_single"></p>
        <p class="fag_single"></p>
        <p class="pris_single"></p>
        <button class="bookknap_single">Book kursus</button>

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
            document.querySelector(".titel_single").textContent = kursus.title.rendered;
            document.querySelector(".pic_single").src = kursus.billede.guid;
            document.querySelector(".langbeskrivelse_single").textContent = kursus.langbeskrivelse;
            document.querySelector(".fag_single").textContent = "📚" + " " + kursus.fag;
            document.querySelector(".pris_single").textContent = "💰" +  " " + "Prisen for kurset er" + " " + kursus.pris + "kr";
        }

        getJson();

        document.querySelector(".tilbageknap_single").addEventListener("click", () => {
        window.history.back();
      });

        </script>

		
	</section><!-- #primary -->

<?php
get_footer();
