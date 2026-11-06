-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 04 nov. 2026 à 14:46
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `idArticle` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'titre de l''article',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contenu de l''article',
  `date` datetime NOT NULL COMMENT 'date de publication de l''article',
  `idUser` int NOT NULL COMMENT 'Identifiant de l''utilisateur ayant créé et publié le l''article.',
  PRIMARY KEY (`idArticle`),
  KEY `user_article` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`idArticle`, `titre`, `description`, `date`, `idUser`) VALUES
(7, 'Les logiciels libres dans le Web', 'Les logiciels libres occupent une place importante dans le développement Web. Un logiciel libre est un programme dont le code source est accessible à tous. Chacun peut l\'utiliser, l\'étudier, le modifier et le redistribuer selon les conditions de sa licence.\r\n\r\nDe nombreux outils Web populaires sont des logiciels libres. Par exemple, Apache et Nginx sont des serveurs Web largement utilisés pour héberger des sites Internet. PHP est un langage de programmation libre permettant de créer des sites dynamiques, tandis que MySQL et MariaDB sont des systèmes de gestion de bases de données open source.\r\n\r\nLes logiciels libres offrent plusieurs avantages : ils sont souvent gratuits, bénéficient d\'une grande communauté d\'utilisateurs et permettent une personnalisation importante. Ils favorisent également l\'innovation et l\'apprentissage en donnant accès au code source.\r\n\r\nAujourd\'hui, une grande partie des sites et applications Web repose sur des technologies libres, ce qui contribue à leur popularité dans les entreprises comme dans le monde de l\'éducation.', '2026-10-29 23:26:20', 2),
(8, 'Les frameworks Java au service de la cybersécurité', 'La sécurité est un enjeu majeur dans le développement d\'applications Web. Pour aider les développeurs à protéger leurs applications contre les accès non autorisés et les attaques courantes, plusieurs frameworks Java spécialisés dans la sécurité ont été créés.\r\n\r\nLe framework Spring Security est aujourd\'hui l\'une des solutions les plus utilisées dans l\'écosystème Java. Il fournit des mécanismes d\'authentification, d\'autorisation et une protection intégrée contre plusieurs attaques courantes comme le CSRF (Cross-Site Request Forgery), le clickjacking ou encore certaines attaques de session. Il est considéré comme le standard de fait pour sécuriser les applications basées sur Spring.\r\n\r\nUn autre framework populaire est Apache Shiro, un projet open source qui permet de gérer l\'authentification des utilisateurs, les autorisations, le chiffrement des données et la gestion des sessions. Son objectif principal est de proposer une API simple à utiliser tout en offrant des fonctionnalités de sécurité complètes pour les applications Java.\r\n\r\nGrâce à ces frameworks, les développeurs peuvent implémenter plus facilement des fonctionnalités de cybersécurité robustes et conformes aux bonnes pratiques, tout en réduisant les risques de vulnérabilités dans leurs applications Web.\r\n\r\nSources\r\nDocumentation officielle Spring Security : https://spring.io/projects/spring-security\r\nDocumentation officielle Apache Shiro : https://shiro.apache.org/', '2026-10-31 13:55:35', 2),
(9, 'Les API REST, un standard du développement Web', 'Les API REST sont largement utilisées pour permettre la communication entre différentes applications. Elles reposent sur le protocole HTTP et utilisent généralement le format JSON pour échanger des données.\r\n\r\nGrâce à une API REST, un site Web, une application mobile ou un logiciel peuvent partager des informations de manière simple et standardisée. Cette approche facilite le développement d\'applications modernes et l\'interconnexion des services.', '2026-10-31 15:08:52', 8),
(10, 'Hibernate, un framework Java pour les bases de données', 'Hibernate est un framework Java permettant de simplifier l\'accès aux bases de données relationnelles. Il implémente le concept d\'ORM (Object-Relational Mapping), qui permet de manipuler les données sous forme d\'objets Java plutôt qu\'avec des requêtes SQL complexes.\r\n\r\nGrâce à Hibernate, les développeurs gagnent du temps et réduisent les risques d\'erreurs lors de la gestion des données dans une application Java.', '2026-10-31 15:09:20', 8),
(11, 'Le chiffrement des mots de passe', 'La protection des mots de passe est essentielle pour sécuriser les comptes utilisateurs. Au lieu de stocker les mots de passe en clair, les applications utilisent des algorithmes de hachage comme bcrypt ou Argon2.\r\n\r\nAinsi, même en cas de fuite de données, les mots de passe originaux sont beaucoup plus difficiles à retrouver. Cette pratique constitue l\'une des bases de la cybersécurité moderne.', '2026-10-31 15:09:35', 8),
(12, 'L\'intelligence artificielle générative', 'L\'intelligence artificielle générative est capable de produire du contenu tel que du texte, des images ou du code informatique. Ces systèmes sont entraînés à partir de grandes quantités de données afin de reproduire des modèles et de générer de nouvelles créations.\r\n\r\nAujourd\'hui, cette technologie est utilisée dans de nombreux domaines comme l\'assistance à la programmation, la création graphique ou encore l\'aide à la rédaction de documents.', '2026-10-31 15:09:56', 8),
(13, 'Le rôle des serveurs DNS sur Internet', 'Les serveurs DNS (Domain Name System) permettent de traduire les noms de domaine en adresses IP. Lorsqu\'un utilisateur saisit une adresse comme « www.example.com », le DNS indique à l\'ordinateur l\'adresse du serveur à contacter.\r\n\r\nSans les DNS, les utilisateurs devraient mémoriser les adresses IP des sites Web. Ce système est donc un élément fondamental du fonctionnement d\'Internet.', '2026-10-31 15:10:12', 8),
(14, 'Les conteneurs Docker dans le développement moderne', 'Docker est une plateforme qui permet d\'exécuter des applications dans des conteneurs légers et isolés. Chaque conteneur embarque l\'application ainsi que toutes ses dépendances, ce qui garantit un fonctionnement identique sur différents ordinateurs ou serveurs. Cette technologie facilite le déploiement des applications Web, améliore la portabilité des projets et simplifie le travail des équipes de développement. Aujourd\'hui, Docker est largement utilisé dans les environnements professionnels pour créer, tester et déployer des applications de manière rapide et fiable.', '2026-10-31 15:11:14', 2),
(15, 'Les index dans les bases de données', 'Les index sont des structures utilisées par les systèmes de gestion de bases de données pour accélérer les recherches. Sans index, la base doit parcourir toutes les lignes d\'une table pour trouver les données demandées. Grâce aux index, les requêtes sont exécutées beaucoup plus rapidement, en particulier sur les tables contenant un grand nombre d\'enregistrements. Il est toutefois important de ne pas abuser des index, car ils occupent de l\'espace et peuvent ralentir certaines opérations d\'écriture.', '2026-10-31 15:25:18', 2),
(16, 'Les collections en Java', 'Java fournit un ensemble de classes appelées Collections permettant de stocker et manipuler des groupes d\'objets. Les structures les plus courantes sont les listes (ArrayList), les ensembles (HashSet) et les dictionnaires (HashMap). Chaque structure possède des caractéristiques particulières adaptées à différents besoins. Les collections facilitent le développement d\'applications en offrant des fonctionnalités puissantes pour organiser les données.', '2026-10-31 15:25:34', 2),
(17, 'Les attaques par phishing', 'Le phishing est une technique utilisée par les cybercriminels pour obtenir des informations sensibles telles que des mots de passe ou des coordonnées bancaires. Les victimes reçoivent généralement un courrier électronique ou un message qui semble provenir d\'un organisme de confiance. En cliquant sur un lien frauduleux, elles peuvent être redirigées vers un faux site imitant le site officiel. La vigilance et la vérification des adresses web permettent de limiter ce type de menace.', '2026-10-31 15:25:47', 2),
(18, 'Le machine learning', 'Le machine learning, ou apprentissage automatique, est une branche de l\'intelligence artificielle permettant aux ordinateurs d\'apprendre à partir de données. Au lieu d\'être programmés pour chaque situation, les modèles sont entraînés à reconnaître des tendances et à prendre des décisions. Cette technologie est utilisée dans de nombreux domaines, notamment la recommandation de contenus, la détection de fraudes, la reconnaissance d\'images et l\'analyse de données.', '2026-10-31 15:26:01', 2),
(19, 'Le protocole HTTPS', 'HTTPS est une version sécurisée du protocole HTTP utilisée pour les échanges de données sur le Web. Grâce au chiffrement TLS, les informations circulant entre le navigateur et le serveur sont protégées contre l\'interception ou la modification par des tiers. Aujourd\'hui, la plupart des sites utilisent HTTPS afin de garantir la confidentialité des données des utilisateurs, d\'améliorer la confiance des visiteurs et de renforcer la sécurité globale des applications web.', '2026-10-31 15:26:19', 2),
(20, 'L’essor de l’intelligence artificielle dans le développement informatique', 'L\'intelligence artificielle (IA) occupe aujourd\'hui une place de plus en plus importante dans le domaine du développement informatique. Grâce aux progrès réalisés dans l\'apprentissage automatique et les réseaux de neurones, les systèmes d\'IA sont capables d\'analyser de grandes quantités de données, de reconnaître des modèles complexes et d\'assister les développeurs dans de nombreuses tâches quotidiennes.\r\n\r\nDans le développement Web, les outils basés sur l\'intelligence artificielle peuvent générer du code, détecter des erreurs de programmation ou encore suggérer des améliorations pour optimiser les performances d\'une application. Ils permettent également d\'automatiser certaines tâches répétitives, ce qui aide les équipes à gagner du temps et à se concentrer sur des problématiques plus complexes.\r\n\r\nL\'IA est aussi utilisée dans des domaines variés tels que la cybersécurité, où elle contribue à détecter des comportements suspects sur un réseau, ou encore dans les bases de données pour analyser des informations et produire des prédictions. Les assistants conversationnels, les systèmes de recommandation et les outils de traduction automatique reposent également sur cette technologie.\r\n\r\nMalgré ses nombreux avantages, l\'intelligence artificielle ne remplace pas les développeurs. Elle constitue plutôt un outil d\'aide à la décision et à la productivité. Les professionnels doivent toujours vérifier les résultats produits afin de garantir leur qualité, leur sécurité et leur conformité aux besoins des utilisateurs.', '2026-11-01 12:40:23', 2),
(21, 'Les bases de données NoSQL et leurs usages', 'Les bases de données NoSQL sont apparues pour répondre aux besoins des applications modernes qui manipulent de très grandes quantités de données. Contrairement aux bases de données relationnelles classiques comme MySQL ou PostgreSQL, elles ne reposent pas forcément sur des tables, des lignes et des colonnes. Elles peuvent stocker les informations sous différentes formes : documents, graphes, colonnes ou paires clé-valeur.\r\n\r\nL\'un des principaux avantages du NoSQL est sa capacité à gérer efficacement des volumes de données importants tout en offrant une grande flexibilité. Lorsqu\'une application évolue rapidement et que sa structure de données change fréquemment, les solutions NoSQL permettent souvent de s\'adapter plus facilement qu\'une base de données relationnelle. Des systèmes comme MongoDB, Cassandra ou Redis sont largement utilisés dans les services web modernes, les réseaux sociaux et les plateformes de commerce en ligne.\r\n\r\nLes bases NoSQL sont également conçues pour être distribuées sur plusieurs serveurs, ce qui améliore leur disponibilité et leurs performances. Elles sont particulièrement adaptées aux applications nécessitant un traitement rapide des données ou une montée en charge importante. Cependant, elles ne remplacent pas systématiquement les bases relationnelles. Le choix entre SQL et NoSQL dépend des besoins du projet, de la structure des données et des contraintes de performance. Aujourd\'hui, de nombreuses entreprises utilisent même les deux approches de manière complémentaire afin de tirer parti des avantages de chacune.', '2026-11-04 14:41:57', 8);

-- --------------------------------------------------------

--
-- Structure de la table `article_categorie`
--

DROP TABLE IF EXISTS `article_categorie`;
CREATE TABLE IF NOT EXISTS `article_categorie` (
  `idArticle` int NOT NULL COMMENT 'Clé étrangère de jointure vers l''identifiant de l''article',
  `idCategorie` int NOT NULL COMMENT 'Clé étrangère de jointure vers l''identifiant de la catégorie',
  PRIMARY KEY (`idArticle`,`idCategorie`),
  KEY `FKCategorie` (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_categorie`
--

INSERT INTO `article_categorie` (`idArticle`, `idCategorie`) VALUES
(7, 1),
(9, 1),
(14, 1),
(19, 1),
(20, 1),
(8, 2),
(10, 2),
(16, 2),
(7, 3),
(10, 3),
(15, 3),
(21, 3),
(8, 4),
(11, 4),
(17, 4),
(19, 4),
(12, 5),
(18, 5),
(20, 5),
(7, 6),
(13, 6),
(14, 6);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de la catégorie',
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nom`) VALUES
(1, 'Développement Web'),
(2, 'Programmation Java'),
(3, 'Base de données'),
(4, 'Cybersécurité'),
(5, 'Intelligence Artificielle'),
(6, 'Systèmes & Réseaux');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `idCommentaire` int NOT NULL AUTO_INCREMENT,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contenu du commentaire',
  `date` datetime NOT NULL COMMENT 'Date de publication du commentaire',
  `idArticle` int NOT NULL COMMENT 'Identifiant de l''article commenté',
  `idUser` int NOT NULL COMMENT 'Identifiant de l''utilisateur ayant publié le commentaire',
  PRIMARY KEY (`idCommentaire`),
  KEY `article_id` (`idArticle`),
  KEY `user_com` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`idCommentaire`, `description`, `date`, `idArticle`, `idUser`) VALUES
(1, 'Voici un bien mauvais article...', '2026-11-04 15:37:58', 21, 2),
(2, 'Excellent, ça me rappel mon cours de Réseaux du semestre 2 !!', '2026-11-04 15:43:36', 19, 2),
(3, 'Très bon article, je me coucherais moins bête !', '2026-11-04 15:43:54', 18, 2),
(4, 'Très bon article, si vous n\'avez pas connaissance des dangers de l\'IA, je vous conseil cette excellente vidéo de Ego sur youtube : https://youtu.be/ZP7T6WAK3Ow?si=UT_RI6ue_2tnI5_A', '2026-11-04 15:45:36', 20, 8);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Adresse mail de l''utilisateur',
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mot de passe haché de l''utilisateur',
  `pseudo` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Début de l''email de l''utilisateur',
  `admin` tinyint(1) NOT NULL COMMENT 'Booléen pour connaître les permissions à accorder à l''utilisateur (1 = administrateur)',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(2, 'noe@gmail.com', '$2y$10$r5UucRaOtg.pmxepfdIwIuifyCXjmviCSoR0NkmC11IyJUuavsRj6', 'noe', 0),
(8, 'Fred69@gmail.com', '$2y$10$LNcGD0swYpUTNNxyP1cTQeqOVj57GMoBoQ5ZasD5v56u0MjSfNCjW', 'Fred69', 0),
(9, 'admin@localhost.fr', '$2y$10$pLmfhNQ2.C6CnbhwO.aRoOagCzKzl9PQ7kskU9MxucjX2vn0g4Bki', 'admin', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `user_article` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `article_categorie`
--
ALTER TABLE `article_categorie`
  ADD CONSTRAINT `FKArticle` FOREIGN KEY (`idArticle`) REFERENCES `article` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKCategorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `article_com` FOREIGN KEY (`idArticle`) REFERENCES `article` (`idArticle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_com` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
