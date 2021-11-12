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


<template>
      <article>
        <img src="" alt="" />
        <div>
        <h2></h2>
        <p class="beskrivelse"></p>
        <p class="fag"></p>
        </div>
        </article>
        </template>

	    <section id="primary" class="content-area">
		<main id="main" class="site-main">

        <section class="kommunecontainer"></section>
        </main><!-- #main -->

        <script>

        let kommuner;
		const url = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/kommune";


		async function getJson() {
  		const response = await fetch(url);
  		kommuner = await response.json();
        console.log(kommuner);
  		visKommuner();
		}

        function visKommuner() {
            let temp = document.querySelector("template");
            let container = document.querySelector(".kommunecontainer");
            kommuner.forEach(kommune =>  {
            let klon = temp.cloneNode(true).content;
            klon.querySelector("h2").textContent = kommune.title.rendered;
            klon.querySelector("img").src = kommune.billede.guid;
            klon.querySelector(".beskrivelse").textContent = kommune.beskrivelse;
            klon.querySelector(".fag").textContent = kommune.fag;
            klon.querySelector("article").addEventListener("click", () => {location.href = kommune.link;})
            container.appendChild(klon);
            })
        }

        getJson ();
        </script>

		
	</section><!-- #primary -->

<?php
get_footer();