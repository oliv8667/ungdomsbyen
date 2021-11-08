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

<head>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/custom.css">
</head>

<nav>
      <button data-kategorier="alle" class="valgt">Alle</button>
      <button data-kategorier="økonomi">Økonomi</button>
      <button data-kategorier="verdensmal">FN’s 17 verdensmål</button>
      <button data-kategorier="demokrati">Demokrati og medborgerskab</button>
      <button data-kategorier="konflikthandtering">Konflikthandtering</button>
    </nav>

<template>
      <article>
        <img src="" alt="" />
        <div>
        <h2></h2>
        <p class="beskrivelse"></p>
        <p class="aergang"></p>
        <p class="fag"></p>
        </div>
        </article>
        </template>

	    <section id="primary" class="content-area">
		<main id="main" class="site-main">

        <section class="kursuscontainer"></section>
        </main><!-- #main -->

        <script>

        let kurser;
        let filter = "alle";
		const url = "https://oliviabang.dk/kea/09_CMS/ungdomsbyen/wordpress/wp-json/wp/v2/kursus?per_page=100";

        document.addEventListener("DOMContentLoaded", start);

        function start() {
        const filterKnapper = document.querySelectorAll("nav button");
        filterKnapper.forEach((knap) =>
            knap.addEventListener("click", filtrerKurser)
        );
        container = document.querySelector(".kursuscontainer");
        temp = document.querySelector("template");
        console.log(temp);
        getJson();
        }

        function filtrerKurser() {
        filter = this.dataset.kategorier;

        visKurser();
      }


		async function getJson() {
  		const response = await fetch(url);
  		kurser = await response.json();
        console.log(kurser);
  		visKurser();
		}

        function visKurser() {
            container.textContent = "";
            kurser.forEach(kursus =>  {
            if (filter == kursus.kategorier || filter == "alle") {
            let klon = temp.cloneNode(true).content;
            klon.querySelector("h2").textContent = kursus.title.rendered;
            klon.querySelector("img").src = kursus.billede.guid;
            klon.querySelector(".beskrivelse").textContent = kursus.beskrivelse;
            klon.querySelector(".fag").textContent = kursus.fag;
            klon.querySelector(".aergang").textContent = kursus.argang;
            klon.querySelector("article").addEventListener("click", () => {location.href = kursus.link;})
            container.appendChild(klon);
                 }
            })
        }

        getJson ();
        </script>

		
	</section><!-- #primary -->

<?php
get_footer();

