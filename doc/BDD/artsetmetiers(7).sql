-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 24 Juin 2013 à 12:37
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `artsetmetiers`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_title` varchar(255) DEFAULT NULL,
  `art_content` text,
  `art_cat_id` int(11) DEFAULT NULL,
  `art_use_id` int(11) NOT NULL,
  `art_dateC` datetime DEFAULT NULL,
  `art_dateM` datetime DEFAULT NULL,
  `art_online` tinyint(1) NOT NULL,
  `art_slot` varchar(100) NOT NULL,
  PRIMARY KEY (`art_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`art_id`, `art_title`, `art_content`, `art_cat_id`, `art_use_id`, `art_dateC`, `art_dateM`, `art_online`, `art_slot`) VALUES
(12, 'Ecrivez moi 100 fois ..', '<p>Bonjour chère visiteurs de Arts & métiers,</p>\r\n<p>Pour inaugurer cette rubrique "testez vous sur .." voici un premier éxercice.<br />Vous devez écrire le plus proprement possible 100 fois "Je dois bien commenter mon code".<br />En PhP et le plus élégament possible c''est à vous la correction est pour demain !</p>\r\n<p>Good luck !</p>', 4, 22, '2013-05-31 16:02:00', '2013-06-12 12:02:00', 1, 'blog'),
(13, 'Whell PHP un framework agile', 'Wheel PhP est un petit framework &quot;Home made&quot;, que j''ai développé à l''occasion du projet de fin d''études NFA021 du CNAM.\r\n\r\nCe Framework utilise PhP 5.3 et respecte le modèle MVC (Model Vue Controller). Dans la série d''article qui vont suivre, je tacherai d''expliquer son fonctionement et de détailler tel une document ces méthodes et ses classes.\r\n\r\nLe framework est composé des dossiers suivants :\r\n[b]Components/[/b]  se trouve les composants utile pour le fonctionement du site (actuellement un seul composant disponible Auth)\r\n[b]config/[/b]  se trouve la classe Config.php à configuré pour votre projet\r\n[b]Controllers/[/b]  C''est dans ce dossier que vous placerez tous les controllers de votre futur projet\r\n[b]core/[/b]  Le coeur du framework vous n''avez jamais à intervenir dedans\r\n[b]doc/[/b] Le dossier dans lequel vous placerez tous les élements de documentation de votre projet\r\n[b]Helpers/[/b]  Contient plusieurs classes utilitaires pour vos projet, vous placerez dedans tous les nouveaux helpers que vous aurez développé en plus de ceux fourni nativement\r\n[b]Models/[/b]  C''est ici que vous placerez tous vos model pour vos projets\r\n[b]views/[/b]  Les vues de vos projets\r\n[b]webroot/[/b]  C''est le seul dossier accessible par les utilisateurs\r\n.htaccess\r\n\r\nVous pouvez acceder à la première page de votre application par l''url www.monsite.com/demo/index ou tout simplement www.monsite.com. En effet Wheel est configuré par défaut pour appeler cette adresse comme page d''accueil (voir Config.php plus loin).\r\n\r\nVoyons de plus près à présent le mécanisme de fonctionnement.\r\nTout d''abord dans Controllers/DemoController.php vous trouverez le code suivant :\r\n[code]\r\nclass DemoController extends Controller{\r\n\r\n   public function index(){\r\n      $this-&gt;layout = ''default'';\r\n      $this-&gt;render(''index'');\r\n   }\r\n\r\n}\r\n[/code]\r\nDans une architecture type MVC le controlleur est composé de plusieurs méthode ou action tel que index dans l''exemple ci dessus. \r\nCette action charge d''abord un layout ''default'' puis renverra avec la méthode Controller::render() une vue (index) pour l''exemple.\r\n\r\nDans views/layouts/default.php se trouve donc le layout utilisé dans notre action index :\r\n[code]\r\n&lt;!DOCTYPE&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n	&lt;meta charset=&quot;UTF-8&quot;&gt;\r\n	&lt;title&gt;Wheel PhP, ne réinventé pas la roue&lt;/title&gt;\r\n	echo $this-&gt;link(''css'', ''bootstrap.min''); &lt;!-- feuille de style pour bootstrap à disposer à votre convenance--&gt;\r\n	//echo $this-&gt;link(''markitup/skins/simple'', ''style'', ''css''); ?&gt; &lt;!-- css pour le plugin js markitup--&gt;\r\n	//echo $this-&gt;link(''markitup/sets/bbcode'', ''style'', ''css''); ?&gt; &lt;!-- feuille de style pour le bbcode  rendez vous sur http://markitup.jaysalvat.com/home/ pour la doc--&gt;\r\n	//echo $this-&gt;link(''css'', ''shCore''); \r\n	echo $this-&gt;link(''css'', ''default'');  &lt;!-- feuille de style css d''exemple --&gt;\r\n	echo $this-&gt;link(''javascript'', ''modernizer'');  &lt;!-- modernizer inclus dans le framework --&gt;\r\n	echo $this-&gt;link(''javascript'', ''jquery'');  &lt;!-- le classique jquery --&gt;\r\n	//echo $this-&gt;link(''markitup'', ''jquery.markitup'', ''javascript''); &lt;!-- des feuilles js pour markitup --&gt;\r\n	//echo $this-&gt;link(''markitup/sets/bbcode'', ''set'', ''javascript''); \r\n	  echo $this-&gt;link(''javascript'', ''default''); ?&gt; &lt;!-- feuille js d''exemple --&gt;\r\n	  echo $this-&gt;link(''javascript'', ''bootstrap.min''); ?&gt; &lt;!-- feuille js pour bootstrap--&gt;\r\n\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n	&lt;h1&gt;Wheel PhP, ne réinventez pas la roue !&lt;/h1&gt;\r\n	&lt;p&gt;Voici le layout par défaut du framework.&lt;/p&gt;\r\n	\r\n	echo $content_for_layout; &lt;!-- cette variable contient la vue par exemple index.php --&gt;\r\n\r\n&lt;/body&gt;\r\n&lt;/html&gt;\r\n\r\n[/code]\r\nNotez les méthodes link en en-têtes de page pour appeler les css et javascript de la page nous y reviendrons plus tard.\r\nCe qu''il faut retenir ici, c''est la ligne :\r\n[code] echo $content_for_layout;[/code]\r\nComme le dit le commentaire chacun de vos layouts doivent posséder cette ligne pour inclure les différentes vues appeler par les actions de vos contrôleurs.\r\nRegardons à présent la ligne :\r\n[code]&lt;?php $this-&gt;render(''index''); ?&gt;[/code]\r\nCette ligne demande d''afficher la vue &quot;index.php&quot; dans le layout default.php à la place de la variable content_for_layout que nous venons de voir.\r\nVoici cette vue index qui se trouve dans views/Demo/index.php\r\n[code]&lt;p&gt;\r\n	Ceci est la &lt;span class=&quot;text-warning&quot;&gt;vue&lt;/span&gt; (index) par défaut du &lt;span class=&quot;text-warning&quot;&gt;controller&lt;/span&gt; Demo.\r\n&lt;/p&gt;[/code]\r\nVous avez en quelques ligne fait fonctionner votre premiere application Wheel PhP, dans le prochain article nous verrons toutes les méthodes de la class Model pour lire, écrire, mettre à jour ou supprimer des données.\r\nA bientot !:)\r\n', 5, 22, '2013-06-11 15:06:00', '2013-06-19 16:05:00', 1, 'blog'),
(14, 'Article de démonstration pour NFA083', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque viverra nisi sit amet vehicula fringilla. In sit amet elementum elit. Sed sed nibh at libero molestie tincidunt convallis id dui. Nam ornare lectus vitae dolor dignissim, nec rhoncus nibh bibendum. Sed porta ultrices congue. Maecenas auctor tellus lorem, non tristique enim varius eu. Nulla sollicitudin consectetur tortor a sodales. Aenean eget laoreet turpis, et tristique mi. Ut consequat varius dolor, in laoreet turpis. Donec vitae interdum velit, in varius risus. Suspendisse nunc arcu, tristique varius velit ac, interdum interdum quam. Nam vestibulum eros vel laoreet dapibus. Integer consectetur nibh sed nibh tempor dapibus. Ut vel placerat ligula. Suspendisse potenti.\r\n\r\nSuspendisse sit amet est velit. Fusce sit amet scelerisque neque. Integer nisl eros, feugiat id laoreet eget, vehicula vitae lorem. Sed vehicula porttitor ligula vel imperdiet. Aenean sollicitudin sem nec commodo fermentum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla vehicula arcu et tortor viverra suscipit a et est. Nulla rhoncus, metus non tempor lobortis, mi justo iaculis orci, id auctor nunc felis sed est.\r\n\r\nMaecenas a gravida ipsum. Aenean sit amet dolor commodo, fermentum lorem vulputate, mollis leo. Aenean id tincidunt ligula. Vivamus in gravida leo. Fusce aliquet massa in augue congue porttitor. Vivamus malesuada arcu bibendum iaculis dignissim. Sed lobortis, mi quis pellentesque varius, neque velit laoreet est, quis congue neque arcu a lectus. Suspendisse semper rhoncus lorem, a varius odio. Suspendisse eu eleifend est. ', 3, 22, '2013-06-18 16:39:00', NULL, 1, 'blog'),
(15, 'Les Exams !', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque viverra nisi sit amet vehicula fringilla. In sit amet elementum elit. Sed sed nibh at libero molestie tincidunt convallis id dui. Nam ornare lectus vitae dolor dignissim, nec rhoncus nibh bibendum. Sed porta ultrices congue. Maecenas auctor tellus lorem, non tristique enim varius eu. Nulla sollicitudin consectetur tortor a sodales. Aenean eget laoreet turpis, et tristique mi. Ut consequat varius dolor, in laoreet turpis. Donec vitae interdum velit, in varius risus. Suspendisse nunc arcu, tristique varius velit ac, interdum interdum quam. Nam vestibulum eros vel laoreet dapibus. Integer consectetur nibh sed nibh tempor dapibus. Ut vel placerat ligula. Suspendisse potenti.\r\n\r\nSuspendisse sit amet est velit. Fusce sit amet scelerisque neque. Integer nisl eros, feugiat id laoreet eget, vehicula vitae lorem. Sed vehicula porttitor ligula vel imperdiet. Aenean sollicitudin sem nec commodo fermentum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla vehicula arcu et tortor viverra suscipit a et est. Nulla rhoncus, metus non tempor lobortis, mi justo iaculis orci, id auctor nunc felis sed est.\r\n\r\nMaecenas a gravida ipsum. Aenean sit amet dolor commodo, fermentum lorem vulputate, mollis leo. Aenean id tincidunt ligula. Vivamus in gravida leo. Fusce aliquet massa in augue congue porttitor. Vivamus malesuada arcu bibendum iaculis dignissim. Sed lobortis, mi quis pellentesque varius, neque velit laoreet est, quis congue neque arcu a lectus. Suspendisse semper rhoncus lorem, a varius odio. Suspendisse eu eleifend est. ', 2, 22, '2013-06-18 16:40:00', NULL, 1, 'blog'),
(16, 'Wheel PhP les méthodes de la class Model', 'Voyons à présent dans cet article comment utiliser les fonctionnalités &quot;CRUD&quot; de toute application php.\r\nConsidérons une table mysql &quot;articles&quot; qui dispose de champs ''art_id'', ''art_titre'', ''art_content''.\r\nDans vos applications Wheel PhP il existe une convention de nommage de vos tables, celles ci doivent toutes être écrites au pluriel, de plus chaque nom de champ doit être préfixé par les trois premières lettres de la table.\r\nNous allons créer dans un contrôleur &quot;Blog&quot; une vue &quot;liste&quot; pour afficher tous les articles.\r\nCréeons d''abord le contrôleur Blog dans le dossier Controllers/BlogController.php.\r\n[code]\r\n&lt;?php class BlogController extends Controller{\r\n  \r\n  /**\r\n  /Création d''une action d''affichage de tous les articles.\r\n  /**\r\n  public function liste(){\r\n    $this-&gt;loadModel(''Article''); //le model doit toujours commencer par une majuscule et toujours au singulier\r\n    $liste_article = $this-&gt;Article-&gt;find(); //cette simple méthode find récupère toutes les données du model Article.\r\n    $this-&gt;set(''liste'', $liste_article); //on crée un tableau liste contenant toutes les données de $liste_article.\r\n    $this-&gt;render(''liste''); //on renvoie tout à la vue nommé liste\r\n  }\r\n\r\n\r\n}\r\n?&gt;\r\n[/code]\r\nVoici ci-dessus la façon la plus simpliste de récupérer les données d''une table. Il reste à créer le model Article qui doit hérité de la classe Model.\r\n[code]\r\n  &lt;?php \r\n  Class Article extends Model{\r\n\r\n  //Cette classe doit être écrit avec la première lettre en majuscule et au singulier contrairement à Mysql où articles doit être écrit au singulier et au pluriel. C''est une convention de nommage de Wheel PhP.\r\n  }\r\n  ?&gt;\r\n[/code]\r\nC''est tout ce qu''il y a à faire au niveau du model. Simple non ?\r\n\r\nRegardons à présent comment afficher dans la vue &quot;liste&quot; les données récuperer en BDD et apres passage dans le controller.\r\n[code]\r\n&lt;?php \r\n//Nous avons donc un array $liste\r\n\r\n  foreach($liste as $k =&gt; $v){\r\n    echo ''&lt;h1&gt;''.$v[''art_titre''].''&lt;/h1&gt;'';\r\n    echo ''&lt;p&gt;''.$v[''art_content''].''&lt;/p&gt;''; \r\n  }\r\n\r\n?&gt;\r\n\r\n[/code]\r\nC''est tout, c''est simple.\r\nVoyons à présent en détail la méthode Controller::find() et tout ces paramètres :\r\n\r\n[code]\r\n//toujours avec le model Article\r\n$data = $this-&gt;Article-&gt;find(array(''fields'' =&gt; ''champ1, champ2, champ3 etc..'',\r\n                                   ''where'' =&gt; array(''champ1'' =&gt; ''tel valeur'', ''champ2'' =&gt; ''tel valeur''));\r\n//le paramètre fields permet de sélectionner uniquement certaines champs\r\n//le paramàtre where permet de rajouter des conditions sélectives\r\n[/code]\r\nRegardons à présent les jointures :\r\n[code]\r\n//considérons une jointure avec une table catégorie, il n''y a pas besoin dans ce cas de charger le modèle catégorie mais uniquement le modèle d''où part la requête.\r\n$this-&gt;loadModel(''Article'');\r\n$data = $this-&gt;Article-&gt;find(array(''join'' =&gt; array(\r\n                                     ''type'' =&gt; ''LEFT OUTER JOIN'',\r\n                                     ''table'' =&gt; ''Catégorie'',\r\n                                     ''condition'' =&gt; ''art_cat_id = cat_id),\r\n                                   ''where'' =&gt; array(''cat_id'' =&gt; 1)));\r\n\r\n[/code]', 5, 22, '2013-06-19 16:46:00', NULL, 1, 'blog');

-- --------------------------------------------------------

--
-- Structure de la table `avatars`
--

CREATE TABLE IF NOT EXISTS `avatars` (
  `ava_id` int(11) NOT NULL AUTO_INCREMENT,
  `ava_url` longtext NOT NULL,
  `ava_id_user` int(11) NOT NULL,
  PRIMARY KEY (`ava_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `avatars`
--

INSERT INTO `avatars` (`ava_id`, `ava_url`, `ava_id_user`) VALUES
(1, 'avatar/tapesec.jpg', 22),
(2, 'avatar/elodie.jpg', 23),
(3, 'avatar/default.png', 25),
(4, 'avatar/default.png', 26),
(5, 'avatar/default.png', 27),
(6, 'avatar/default.png', 28),
(7, 'avatar/default.png', 29),
(8, 'avatar/default.png', 30);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'PHP'),
(2, 'CNAM'),
(3, 'HTML5 / CSS3'),
(4, 'EXERCICE'),
(5, 'Wheel PHP');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_content` longtext NOT NULL,
  `com_dateC` datetime NOT NULL,
  `com_dateM` datetime NOT NULL,
  `com_id_user` int(11) NOT NULL,
  `com_id_article` int(11) NOT NULL,
  `com_name_editor` varchar(100) NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`com_id`, `com_content`, `com_dateC`, `com_dateM`, `com_id_user`, `com_id_article`, `com_name_editor`) VALUES
(2, 'Un nouveau commentaire de test avec un format beaucoup plus long. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin commodo arcu ac purus interdum et auctor quam dictum. Pellentesque a elit eget diam feugiat vestibulum. Praesent ut lectus ac erat faucibus interdum. Mauris porta venenatis tellus, et consequat lorem commodo vel. Sed ac erat eu metus pharetra viverra. Suspendisse euismod erat a dolor pharetra ut tempor turpis fringilla. Etiam in est non erat interdum posuere sodales a est. Sed vestibulum lorem quis risus scelerisque tincidunt. Nulla imperdiet leo vel diam accumsan in luctus lectus commodo. .', '2013-05-30 00:00:00', '2013-05-29 14:19:00', 22, 11, 'tapesec'),
(8, 'Un nouveau commentaire.', '2013-05-29 14:22:00', '2013-05-29 14:27:00', 23, 11, 'elodie'),
(15, '[code]<?php \r\n$hello = ''hello world !'';\r\necho ''<p>''.$hello.''</pre>''; ?>[/code]', '2013-05-30 14:02:00', '0000-00-00 00:00:00', 22, 11, ''),
(25, '[code]<?php echo ''hello world''; ?>[/code]', '2013-05-30 15:24:00', '0000-00-00 00:00:00', 22, 11, ''),
(26, '[code]\r\n<?php for($i=0;$i<100;$i++): ?>\r\n   echo ''Je dois bien commenter mon code'';\r\n<?php endfor; ?>\r\n<?php for($i=0;$i<100;$i++): ?>\r\n   echo ''Je dois bien commenter mon code'';\r\n<?php endfor; ?>\r\n<?php for($i=0;$i<100;$i++): ?>\r\n   echo ''Je dois bien commenter mon code'';\r\n<?php endfor; ?>\r\n[/code]', '2013-05-31 16:18:00', '2013-05-31 20:22:00', 22, 12, 'tapesec');

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE IF NOT EXISTS `diplomes` (
  `dip_id` int(11) NOT NULL AUTO_INCREMENT,
  `dip_name` varchar(255) NOT NULL,
  `dip_code` varchar(10) NOT NULL,
  `dip_img_url` longtext NOT NULL,
  PRIMARY KEY (`dip_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `diplomes`
--

INSERT INTO `diplomes` (`dip_id`, `dip_name`, `dip_code`, `dip_img_url`) VALUES
(2, 'Certificat de programmation de site web', 'CP09', 'parcours/diplome/CP09.jpg'),
(3, 'Diplôme d''établissement - niveau bac +2 analyste-programmeur ', 'DIE20p-1', '/parcours/diplome/default.jpg'),
(4, 'Diplôme universitaire de technologie informatique ', 'DUT12p-1', '/parcours/diplome/default.jpg'),
(5, 'Certificat professionnel Programmeur d''applications mobiles ', 'CP48p-1', '/parcours/diplome/default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `dunites`
--

CREATE TABLE IF NOT EXISTS `dunites` (
  `dun_id` int(11) NOT NULL AUTO_INCREMENT,
  `dun_dip_id` int(11) NOT NULL,
  `dun_uni_id` int(11) NOT NULL,
  PRIMARY KEY (`dun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `dunites`
--

INSERT INTO `dunites` (`dun_id`, `dun_dip_id`, `dun_uni_id`) VALUES
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 6),
(6, 2, 7),
(7, 2, 8),
(8, 3, 10),
(12, 2, 1),
(13, 3, 7),
(14, 3, 2),
(15, 3, 1),
(16, 3, 3),
(17, 3, 4),
(18, 3, 6),
(19, 3, 8),
(20, 2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE IF NOT EXISTS `matieres` (
  `mat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mat_name` varchar(100) DEFAULT NULL,
  `mat_url` longtext,
  `mat_statut` tinyint(1) DEFAULT NULL,
  `mat_start` datetime DEFAULT NULL,
  `mat_end` datetime DEFAULT NULL,
  `mat_succes` tinyint(1) DEFAULT NULL,
  `mat_obtention` datetime DEFAULT NULL,
  PRIMARY KEY (`mat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `matieres`
--

INSERT INTO `matieres` (`mat_id`, `mat_name`, `mat_url`, `mat_statut`, `mat_start`, `mat_end`, `mat_succes`, `mat_obtention`) VALUES
(1, 'Développement web niveau 1 (NFA016)', '/img/parcours/nfa016off.jpg', 0, '2013-09-15 00:00:00', '2014-01-01 00:00:00', NULL, NULL),
(2, 'Base de données (NFA 008)', '/img/parcours/nfa008off.jpg', NULL, '2013-09-11 00:00:00', '2014-01-15 00:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pag_id` int(11) NOT NULL AUTO_INCREMENT,
  `pag_name` varchar(100) NOT NULL,
  `pag_url` longtext NOT NULL,
  `pag_src` longtext NOT NULL,
  `pag_type` varchar(100) NOT NULL,
  PRIMARY KEY (`pag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`pag_id`, `pag_name`, `pag_url`, `pag_src`, `pag_type`) VALUES
(1, 'Blog', '/blog/index', '', 'front'),
(2, 'Carte de visite', '/parcours/voir', '', 'front'),
(4, 'Forum', '/forum/index', '', 'front'),
(5, 'Interface administration', '/backoff/index', '', 'back'),
(6, 'Ecrire un article', '/backoff/addArticle', 'design/img/ecrire.png', 'back'),
(7, 'Liste des articles', '/backoff/listArticle', 'design/img/listArticle.png', 'back'),
(8, 'Configuration du forum', '/backoff/forum', 'design/img/forum.png', 'back'),
(9, 'Configuration des membres', '/backoff/listUsers', 'design/img/membres.png', 'back'),
(10, 'Thèmes du blog', '/backoff/listCat', 'design/img/listCat.png', 'back'),
(11, 'Accueil', '/accueil/index', '', 'front'),
(12, 'Configuration des Diplomes', '/backoff/diplome', 'design/img/diplome.png', 'back'),
(13, 'Configuration des Unités d''Enseignements', '/backoff/unite', 'design/img/unites.png', 'back');

-- --------------------------------------------------------

--
-- Structure de la table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_id_subjects` int(45) DEFAULT NULL,
  `rep_id_author` int(45) DEFAULT NULL,
  `rep_editor` varchar(100) NOT NULL,
  `rep_title` varchar(45) DEFAULT NULL,
  `rep_content` longtext,
  `rep_dateC` datetime DEFAULT NULL,
  `rep_dateM` datetime DEFAULT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `replies`
--

INSERT INTO `replies` (`rep_id`, `rep_id_subjects`, `rep_id_author`, `rep_editor`, `rep_title`, `rep_content`, `rep_dateC`, `rep_dateM`) VALUES
(1, 1, 22, 'tapesec', 'Ma premiere réponse', 'Il était une fois un marchand de foie voyons si je rajoute un max de texte ce qu''il arrive. Tiens note pour plus tard, il faut que je mettre en place la solution markitup comme éditeur de texte ca sera plus sympa qu''un textearéa bourrin', '2013-05-29 00:00:00', '2013-05-27 15:33:00'),
(14, 2, 22, 'tapesec', 'it works !', 'Une phrase claire', '2013-05-23 16:17:00', '2013-06-06 11:58:00'),
(15, 1, 22, 'tapesec', 'nouveau sujet', 'C''est là ou on voit si tout a foutu le camp pour le moment oui', '2013-05-24 17:09:00', '2013-06-05 10:59:00'),
(18, 3, 23, 'elodie', 'Une réponse venant de elodie', 'Et du texte venant de Elodie répondant au sujet :  "Un sujet sous bootstrap" posté par tapesec', '2013-05-27 16:13:00', '2013-05-27 16:14:00'),
(19, 4, 23, 'elodie', 'Une première réponse de Elodie', 'Voilà la réponse rien de anormal pour le moment', '2013-05-27 16:16:00', NULL),
(20, 4, 22, 'tapesec', 'Et une réponse de Tapesec', 'Une réponse de tapesec pour verifier si ca colle mais je doute.', '2013-05-27 16:16:00', NULL),
(21, 1, 23, 'tapesec', 'Une réponse de Elodie', 'Cela commence à sentir bon n''est il pas ?', '2013-05-27 16:37:00', NULL),
(22, 5, 22, 'tapesec', 'Une réponse', 'Réédition du sujet où tout déconne', '2013-06-05 10:26:00', '2013-06-05 10:32:00'),
(23, 5, 22, 'tapesec', 'Nouveau sujet', 'Edition de voyons ça', '2013-06-05 10:32:00', '2013-06-05 10:32:00');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_name` varchar(100) DEFAULT NULL,
  `sec_online` tinyint(1) NOT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `sections`
--

INSERT INTO `sections` (`sec_id`, `sec_name`, `sec_online`) VALUES
(1, 'Développement Web', 1),
(7, 'Réseau et Web', 1),
(8, 'Base de données', 1),
(9, 'Développement Java introduction', 1);

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_content` longtext,
  `sub_id_sections` int(11) DEFAULT NULL,
  `sub_id_author` int(11) DEFAULT NULL,
  `sub_title` varchar(100) DEFAULT NULL,
  `sub_dateC` datetime DEFAULT NULL,
  `sub_dateM` datetime DEFAULT NULL,
  `sub_postit` tinyint(1) NOT NULL,
  `sub_online` tinyint(1) NOT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `subjects`
--

INSERT INTO `subjects` (`sub_id`, `sub_content`, `sub_id_sections`, `sub_id_author`, `sub_title`, `sub_dateC`, `sub_dateM`, `sub_postit`, `sub_online`) VALUES
(1, 'Voici un sujet que l''on nommera bienvenue sur la section Y', 1, 22, 'Le titre de mon premier sujet', '2013-05-22 00:00:00', NULL, 1, 1),
(2, ' <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eros magna, mattis id aliquam ut, luctus id velit. Phasellus turpis eros, fringilla faucibus porttitor id, volutpat nec risus. Suspendisse eu mauris neque, eu condimentum tellus. Etiam nunc magna, adipiscing et cursus lacinia, fringilla in ipsum. Nam lectus lacus, suscipit eu egestas vitae, cursus eget orci. In a placerat urna. Sed sed felis urna, vitae vulputate turpis. In fermentum lorem eu lorem semper blandit. In pulvinar suscipit risus id aliquam. Maecenas mattis, nulla eget vulputate mollis, massa orci dapibus metus, feugiat faucibus elit augue eget nisi. Nullam posuere suscipit commodo.</p>\r\n\r\n<p>Ut non aliquet urna. Quisque et nulla et elit semper scelerisque. Nullam sodales mattis urna eu porttitor. Phasellus erat lorem, pellentesque a congue sit amet, blandit vitae diam. Vivamus vel felis neque. Morbi posuere sagittis placerat. Sed congue, sem et placerat pulvinar, odio felis dapibus massa, eget sagittis neque neque facilisis felis. In hac habitasse platea dictumst. Suspendisse id tortor quis purus mattis vehicula sed nec risus. </p>', 1, 22, 'Le titre de mon second sujet', '2013-05-29 00:00:00', '2013-05-31 00:00:00', 0, 1),
(3, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eros magna, mattis id aliquam ut, luctus id velit. Phasellus turpis eros, fringilla faucibus porttitor id, volutpat nec risus. Suspendisse eu mauris neque, eu condimentum tellus. Etiam nunc magna, adipiscing et cursus lacinia, fringilla in ipsum. Nam lectus lacus, suscipit eu egestas vitae, cursus eget orci. In a placerat urna. Sed sed felis urna, vitae vulputate turpis. In fermentum lorem eu lorem semper blandit. In pulvinar suscipit risus id aliquam. Maecenas mattis, nulla eget vulputate mollis, massa orci dapibus metus, feugiat faucibus elit augue eget nisi. Nullam posuere suscipit commodo.\r\n\r\nUt non aliquet urna. Quisque et nulla et elit semper scelerisque. Nullam sodales mattis urna eu porttitor. Phasellus erat lorem, pellentesque a congue sit amet, blandit vitae diam. Vivamus vel felis neque. Morbi posuere sagittis placerat. Sed congue, sem et placerat pulvinar, odio felis dapibus massa, eget sagittis neque neque facilisis felis. In hac habitasse platea dictumst. Suspendisse id tortor quis purus mattis vehicula sed nec risus. ', 1, 22, 'Un sujet sous bootstrap', '2013-05-27 15:39:00', NULL, 0, 1),
(4, ' <p>Morbi ipsum enim, varius at tempor sit amet, fermentum a ipsum. Vivamus et eros et purus scelerisque blandit eget id urna. Ut volutpat turpis lacus. Proin fermentum sagittis tempor. Vivamus et est turpis. Quisque dapibus ante at dui vestibulum non dictum metus tempor. Donec semper lectus eleifend neque rutrum tempor. In a leo ligula, non congue nisl. Ut adipiscing tristique commodo. Proin et sem quis mi viverra placerat vitae consequat enim. In faucibus adipiscing venenatis. Maecenas elementum malesuada sem nec dignissim. In eu diam nunc. Proin id nunc ac ipsum viverra dapibus. Morbi quis quam eget risus tempor pretium eget quis urna. Phasellus mattis tincidunt erat.</p>\r\n\r\n<p>Aenean pellentesque mi non lacus tristique ac pulvinar massa venenatis. Mauris fermentum sem non nulla blandit eu hendrerit purus semper. Curabitur in orci ac risus dignissim ullamcorper. Vivamus volutpat quam vitae ligula ornare sollicitudin. Nulla dolor velit, vulputate et imperdiet at, tincidunt ac erat. Ut dictum lorem justo. Suspendisse potenti. Integer molestie lorem et lectus iaculis venenatis. Vivamus at elit a velit porttitor luctus eget quis purus. Curabitur justo lacus, rutrum vel blandit vel, ultricies rutrum sapien. Duis cursus vehicula diam quis egestas. Nulla et arcu quis dolor consequat fringilla. In id ipsum id tellus egestas dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>', 1, 23, 'Un nouveau sujet de Elodie', '2013-05-27 16:15:00', NULL, 0, 1),
(5, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer viverra tempus ipsum ac fermentum. In erat nibh, rutrum vitae laoreet blandit, auctor sit amet magna. Nam rhoncus nulla vitae est porttitor imperdiet aliquet in lectus. Donec ultrices pharetra venenatis. Sed ultrices, sapien at bibendum molestie, enim lorem porta est, adipiscing rutrum libero mi et metus. Phasellus fringilla enim sed nunc mollis vulputate. Fusce porttitor elementum lorem a placerat. Vivamus cursus, ligula molestie rhoncus porttitor, justo risus egestas ante, ut pharetra lacus nisl eu augue. Pellentesque nulla turpis, placerat eu auctor porta, imperdiet eu erat. Nulla tellus mauris, commodo nec facilisis sit amet, mollis eu ante.\r\n\r\nSuspendisse tincidunt pharetra diam quis sollicitudin. Praesent eu massa lacus. Proin elementum, augue in pulvinar imperdiet, erat sem porta urna, ut ultrices risus lectus eget sapien. Vestibulum eros justo, fringilla at aliquet eu, laoreet mattis nisi. Proin blandit imperdiet turpis, sit amet tristique ipsum suscipit quis. Cras rhoncus est vulputate lacus semper laoreet. Suspendisse at dui lorem. Vestibulum commodo ante eu sem mollis rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ', 1, 22, 'Un sujet de test car des choses déconne', '2013-06-05 10:26:00', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `udiplomes`
--

CREATE TABLE IF NOT EXISTS `udiplomes` (
  `udi_id` int(11) NOT NULL AUTO_INCREMENT,
  `udi_use_id` int(11) NOT NULL,
  `udi_dip_id` int(11) NOT NULL,
  PRIMARY KEY (`udi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Contenu de la table `udiplomes`
--

INSERT INTO `udiplomes` (`udi_id`, `udi_use_id`, `udi_dip_id`) VALUES
(103, 22, 2),
(108, 24, 2),
(109, 22, 3);

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE IF NOT EXISTS `unites` (
  `uni_id` int(11) NOT NULL AUTO_INCREMENT,
  `uni_code` varchar(10) NOT NULL,
  `uni_name` varchar(255) NOT NULL,
  `uni_img_url` longtext NOT NULL,
  PRIMARY KEY (`uni_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `unites`
--

INSERT INTO `unites` (`uni_id`, `uni_code`, `uni_name`, `uni_img_url`) VALUES
(1, 'NFA016', 'Développement Web (1)', 'parcours/UE/.png'),
(2, 'NFA017', 'Développement Web (2)', '/parcours/UE/default.jpg'),
(3, 'NFA021', 'Développement Web (3)', '/parcours/UE/default.jpg'),
(4, 'NFA083', 'Réseau et Web', '/parcours/UE/default.jpg'),
(6, 'NFA084', 'Graphismes et Web', '/parcours/UE/default.jpg'),
(7, 'NFA031', 'Programmation avec Java : notions de base', '/parcours/UE/default.jpg'),
(8, ' NFA008', 'Bases de données [6 ECTS]', '/parcours/UE/default.jpg'),
(10, 'NFA050', 'Algorythme', '/parcours/UE/default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `use_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_login` varchar(255) NOT NULL,
  `use_mail` varchar(255) NOT NULL,
  `use_prenom` varchar(150) NOT NULL,
  `use_age` varchar(3) NOT NULL,
  `use_profession` varchar(250) NOT NULL,
  `use_residence` varchar(100) NOT NULL,
  `use_etudes` varchar(255) NOT NULL,
  `use_obs` longtext NOT NULL,
  `use_password1` varchar(255) NOT NULL,
  `use_password2` varchar(255) NOT NULL,
  `use_link` varchar(255) NOT NULL,
  `use_dateI` datetime NOT NULL,
  `use_dateC` datetime NOT NULL,
  `use_statut` int(1) NOT NULL,
  `use_checked` tinyint(1) NOT NULL,
  PRIMARY KEY (`use_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`use_id`, `use_login`, `use_mail`, `use_prenom`, `use_age`, `use_profession`, `use_residence`, `use_etudes`, `use_obs`, `use_password1`, `use_password2`, `use_link`, `use_dateI`, `use_dateC`, `use_statut`, `use_checked`) VALUES
(22, 'tapesec', 'lionel.dupouy@gmail.com', 'Lionnel', '29', 'Developpeur', 'Paris', 'CNAM', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lacus erat, sagittis ut magna ac, molestie tempor magna. Curabitur adipiscing nulla at odio tristique vulputate. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. \r\nNulla facilisi. Proin neque sem, mollis sit amet tempus ac, porta nec nisl. Vestibulum porta semper nisi sed euismod. Aliquam aliquam augue semper lorem accumsan, vitae molestie libero semper. Donec eu sodales elit. ', 'wolf', 'wolf', '', '2013-05-01 12:00:00', '2013-06-24 14:01:00', 10, 1),
(23, 'elodie', 'elodie@gmail.com', '', '', '', '', '', '', 'wolf', 'wolf', '', '2013-06-01 10:00:00', '2013-06-07 19:25:00', 2, 1),
(24, 'louise', 'louise@gmail.com', 'Louise', '', 'adorable', 'Ivry', 'rien', 'Bonjour je voudrais devenir riche :D', 'wolf', 'wolf', '', '2013-04-19 01:00:00', '2013-06-06 09:37:00', 1, 1),
(25, 'chatouille', 'chat@gmail.com', '', '', '', '', '', '', 'wolf', 'wolf', '', '2013-06-01 21:00:00', '0000-00-00 00:00:00', 1, 1),
(26, 'Gaelle', 'gaelle@gmail.com', '', '', '', '', '', '', 'wolf', 'wolf', '', '2013-05-28 14:15:00', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `uunites`
--

CREATE TABLE IF NOT EXISTS `uunites` (
  `uun_id` int(11) NOT NULL AUTO_INCREMENT,
  `uun_use_id` int(11) NOT NULL,
  `uun_uni_id` int(11) NOT NULL,
  `uun_uni_statut` tinyint(1) NOT NULL,
  PRIMARY KEY (`uun_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Contenu de la table `uunites`
--

INSERT INTO `uunites` (`uun_id`, `uun_use_id`, `uun_uni_id`, `uun_uni_statut`) VALUES
(35, 22, 4, 0),
(36, 22, 3, 0),
(37, 22, 6, 0),
(38, 22, 2, 0),
(39, 22, 1, 1),
(40, 22, 4, 1),
(45, 24, 10, 1),
(46, 24, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `vis_id` int(11) NOT NULL AUTO_INCREMENT,
  `vis_ip` varchar(50) NOT NULL,
  `vis_type` varchar(20) NOT NULL,
  `vis_type_id` int(11) NOT NULL,
  PRIMARY KEY (`vis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `visits`
--

INSERT INTO `visits` (`vis_id`, `vis_ip`, `vis_type`, `vis_type_id`) VALUES
(1, '127.0.0.1', 'posts', 1),
(2, '127.0.0.1', 'posts', 1),
(3, '127.0.0.1', 'posts', 1),
(4, '127.0.0.1', 'posts', 1),
(5, '127.0.0.1', 'posts', 5),
(6, '127.0.0.1', 'posts', 3),
(7, '127.0.0.1', 'posts', 4),
(8, '127.0.0.1', 'posts', 2),
(9, '127.0.0.1', 'posts', 2),
(10, '127.0.0.1', 'posts', 1),
(11, '127.0.0.1', 'posts', 1),
(12, '127.0.0.1', 'posts', 1),
(13, '127.0.0.1', 'posts', 1),
(14, '127.0.0.1', 'posts', 1),
(15, '127.0.0.1', 'posts', 1),
(16, '127.0.0.1', 'posts', 1),
(17, '127.0.0.1', 'posts', 1),
(18, '127.0.0.1', 'posts', 1),
(19, '127.0.0.1', 'posts', 1),
(20, '127.0.0.1', 'posts', 1),
(21, '127.0.0.1', 'posts', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
