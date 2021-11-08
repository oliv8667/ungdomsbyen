<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

	    <section id="primary" class="content-area">
		<main id="main" class="site-main">

        <button>Tilbage</button>

        <article>
        <img class="pic" src="" alt="" />
        <div>
        <h2></h2>
        <p class="beskrivelse"></p>
        <p class="aergang"></p>
        <p class="fag"></p>
        </div>
        </article>

        </main><!-- #main -->

        <script>

        let kursus;
		const url = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/kursus"+<?php echo get_the_ID() ?>;

		async function getJson() {
        console.log("id er", <?php echo get_the_ID() ?>);
  		const response = await fetch(url);
  		kursus = await response.json();
  		visKursus();
        console.log(kursus);
		}

        function visKursus() {
            document.querySelector("h2").textContent = kursus.title.rendered;
            document.querySelector(".pic").src = kursus.billede.guid;
            document.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
            document.querySelector(".aergang").textContent = kursus.argang;
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
