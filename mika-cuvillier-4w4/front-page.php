<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme-4w4 
 */
 
get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
		<section id="annonce"></section>
		<?php
			echo '<h2>Les cours du TIM</h2>' ;
			echo '<h3>' . category_description(get_cat_ID('cours')) . '</h3>' ;
		?>
		</header><!-- .page-header -->
		<div class='cours-accueil'>
		<?php
				/* Start the Loop */
				$precedent = "XXXXXXX";
				$ctrl_radio = "";
				while ( have_posts() ) :
					the_post();
					convertir_tableau($tPropriété);
					if ($precedent != $tPropriété['typeCours']): ?>
					  	<?php if ($precedent != "XXXXXXX"): ?>
							</section>
						<?php endif;?>
						<?php if (in_array($precedent, ['Web', 'Jeu', 'spécifique'])) : ?>	
							<section class="ctrl-carrousel  largeur_33">
								<?php echo $ctrl_radio;
									$ctrl_radio = ""; 
								?>
							</section>
						<?php endif;?>
						<h2><?php echo $tPropriété['typeCours'] ?></h2>
						<section <?php echo class_composant($tPropriété['typeCours']) ?>>
					<?php endif;?>	
					<?php 
					if (in_array($tPropriété['typeCours'], ['Web', 'Jeu', 'spécifique'])) : 
						get_template_part( 'template-parts/content', 'carrousel' );
						$ctrl_radio .= '<input type="radio" name="rad-'. $tPropriété['typeCours'] .'">';
					elseif($tPropriété['typeCours'] == 'Projet'):
						get_template_part( 'template-parts/content', 'galerie' );
					else:
						get_template_part( 'template-parts/content', 'bloc' );
					endif; 
					$precedent = $tPropriété['typeCours'];
				endwhile; ?>
			</section>
<!-- //////////////////////////////////////////////////////////////////////
	Formulaire d'ajout d'un article de catégorie << Nouvelles >>  -->
			<section class="admin-rapid">
			<h3>Ajouter un article de catégorie Nouvelles</h3>
			<input type="text" name="title" placeholder="Titre">
			<textarea name="content" placeholder="Contenu"></textarea>
			<button id="bout-rapid">Créer une Nouvelle</button>

			</section>


			<section class="nouvelles">
				<!-- <button id="bout_nouvelles">Dernières Nouvelles</button> -->
				<section></section>
			</section>
		<?php endif; ?>
</main><!-- #main -->
<?php
//get_sidebar();
get_footer();

function convertir_tableau(&$tPropriété){
	$titre_grand = get_the_title();  
	$tPropriété['session'] = substr($titre_grand, 4,1);
	$tPropriété['nbHeure'] = substr($titre_grand,-4,3 );
	$tPropriété['titre'] = substr($titre_grand,8, -6);
	$tPropriété['sigle'] = substr($titre_grand,0, 7);
	$tPropriété['typeCours'] = get_field('type_de_cours'); 
}

function class_composant($typeCours){
	if(in_array($typeCours,['Web', 'Jeu', 'spécifique'])){
		return 'class="slider"';
	}
	elseif($typeCours == 'Projet'){
		return 'class="galerie"';
	}
	else{
		return 'class="bloc"';
	}
}

function genere_bouton_radio($type){
	
}


function selectionne_svg($type_de_cours){
	switch($type_de_cours) {
		case "Web" :
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ff5500" fill-opacity="0.5" d="M0,64L40,101.3C80,139,160,213,240,218.7C320,224,400,160,480,154.7C560,149,640,203,720,218.7C800,235,880,213,960,213.3C1040,213,1120,235,1200,229.3C1280,224,1360,192,1400,176L1440,160L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>';
			    	

			case "Jeu" :
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
			<path fill="#0099ff" fill-opacity="1" d="M0,32L6.2,37.3C12.3,43,25,53,37,53.3C49.2,53,62,43,74,80C86.2,117,98,203,111,240C123.1,277,135,267,148,266.7C160,267,172,277,185,240C196.9,203,209,117,222,117.3C233.8,117,246,203,258,224C270.8,245,283,203,295,197.3C307.7,192,320,224,332,202.7C344.6,181,357,107,369,85.3C381.5,64,394,96,406,101.3C418.5,107,431,85,443,74.7C455.4,64,468,64,480,96C492.3,128,505,192,517,224C529.2,256,542,256,554,234.7C566.2,213,578,171,591,176C603.1,181,615,235,628,224C640,213,652,139,665,112C676.9,85,689,107,702,112C713.8,117,726,107,738,101.3C750.8,96,763,96,775,85.3C787.7,75,800,53,812,48C824.6,43,837,53,849,64C861.5,75,874,85,886,122.7C898.5,160,911,224,923,224C935.4,224,948,160,960,117.3C972.3,75,985,53,997,42.7C1009.2,32,1022,32,1034,42.7C1046.2,53,1058,75,1071,106.7C1083.1,139,1095,181,1108,213.3C1120,245,1132,267,1145,234.7C1156.9,203,1169,117,1182,101.3C1193.8,85,1206,139,1218,176C1230.8,213,1243,235,1255,202.7C1267.7,171,1280,85,1292,69.3C1304.6,53,1317,107,1329,154.7C1341.5,203,1354,245,1366,218.7C1378.5,192,1391,96,1403,58.7C1415.4,21,1428,43,1434,53.3L1440,64L1440,320L1433.8,320C1427.7,320,1415,320,1403,320C1390.8,320,1378,320,1366,320C1353.8,320,1342,320,1329,320C1316.9,320,1305,320,1292,320C1280,320,1268,320,1255,320C1243.1,320,1231,320,1218,320C1206.2,320,1194,320,1182,320C1169.2,320,1157,320,1145,320C1132.3,320,1120,320,1108,320C1095.4,320,1083,320,1071,320C1058.5,320,1046,320,1034,320C1021.5,320,1009,320,997,320C984.6,320,972,320,960,320C947.7,320,935,320,923,320C910.8,320,898,320,886,320C873.8,320,862,320,849,320C836.9,320,825,320,812,320C800,320,788,320,775,320C763.1,320,751,320,738,320C726.2,320,714,320,702,320C689.2,320,677,320,665,320C652.3,320,640,320,628,320C615.4,320,603,320,591,320C578.5,320,566,320,554,320C541.5,320,529,320,517,320C504.6,320,492,320,480,320C467.7,320,455,320,443,320C430.8,320,418,320,406,320C393.8,320,382,320,369,320C356.9,320,345,320,332,320C320,320,308,320,295,320C283.1,320,271,320,258,320C246.2,320,234,320,222,320C209.2,320,197,320,185,320C172.3,320,160,320,148,320C135.4,320,123,320,111,320C98.5,320,86,320,74,320C61.5,320,49,320,37,320C24.6,320,12,320,6,320L0,320Z"></path>
		  </svg>';
		case "Image 2d/3d": 
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
			<path fill="#0099ff" fill-opacity="0.2" d="M0,192L20,170.7C40,149,80,107,120,74.7C160,43,200,21,240,32C280,43,320,85,360,128C400,171,440,213,480,218.7C520,224,560,192,600,176C640,160,680,160,720,181.3C760,203,800,245,840,240C880,235,920,181,960,144C1000,107,1040,85,1080,69.3C1120,53,1160,43,1200,58.7C1240,75,1280,117,1320,144C1360,171,1400,181,1420,186.7L1440,192L1440,320L1420,320C1400,320,1360,320,1320,320C1280,320,1240,320,1200,320C1160,320,1120,320,1080,320C1040,320,1000,320,960,320C920,320,880,320,840,320C800,320,760,320,720,320C680,320,640,320,600,320C560,320,520,320,480,320C440,320,400,320,360,320C320,320,280,320,240,320C200,320,160,320,120,320C80,320,40,320,20,320L0,320Z"></path>
		  </svg>';  
		case "Spécifique" : 
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
			<path fill="#ffd700" fill-opacity="1" d="M0,32L60,32C120,32,240,32,360,69.3C480,107,600,181,720,181.3C840,181,960,107,1080,85.3C1200,64,1320,96,1380,112L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
		  </svg>';
		case "Conception" : 
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
			<path fill="#00cba9" fill-opacity="0.2" d="M0,224L13.3,224C26.7,224,53,224,80,213.3C106.7,203,133,181,160,154.7C186.7,128,213,96,240,85.3C266.7,75,293,85,320,96C346.7,107,373,117,400,154.7C426.7,192,453,256,480,240C506.7,224,533,128,560,74.7C586.7,21,613,11,640,16C666.7,21,693,43,720,85.3C746.7,128,773,192,800,213.3C826.7,235,853,213,880,202.7C906.7,192,933,192,960,202.7C986.7,213,1013,235,1040,213.3C1066.7,192,1093,128,1120,106.7C1146.7,85,1173,107,1200,144C1226.7,181,1253,235,1280,261.3C1306.7,288,1333,288,1360,272C1386.7,256,1413,224,1427,208L1440,192L1440,320L1426.7,320C1413.3,320,1387,320,1360,320C1333.3,320,1307,320,1280,320C1253.3,320,1227,320,1200,320C1173.3,320,1147,320,1120,320C1093.3,320,1067,320,1040,320C1013.3,320,987,320,960,320C933.3,320,907,320,880,320C853.3,320,827,320,800,320C773.3,320,747,320,720,320C693.3,320,667,320,640,320C613.3,320,587,320,560,320C533.3,320,507,320,480,320C453.3,320,427,320,400,320C373.3,320,347,320,320,320C293.3,320,267,320,240,320C213.3,320,187,320,160,320C133.3,320,107,320,80,320C53.3,320,27,320,13,320L0,320Z"></path>
		  </svg>';  	
	}
}