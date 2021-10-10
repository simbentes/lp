-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 07-Jun-2021 às 14:37
-- Versão do servidor: 8.0.23
-- versão do PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `deca_20l4_03`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `albuns`
--

CREATE TABLE `albuns` (
  `id_albuns` int NOT NULL,
  `titulo` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ano` year NOT NULL,
  `descricao` text,
  `ref_id_artistas` int NOT NULL,
  `ref_id_rotacoes` int DEFAULT NULL,
  `ref_id_editoras` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `albuns`
--

INSERT INTO `albuns` (`id_albuns`, `titulo`, `ano`, `descricao`, `ref_id_artistas`, `ref_id_rotacoes`, `ref_id_editoras`) VALUES
(30, 'L.A. Woman', 1971, 'L.A. Woman is the sixth studio album by the American rock band the Doors, released on April 19, 1971, by Elektra Records. It is the last to feature lead singer Jim Morrison during his lifetime due to his death three months after the album\'s release, though he would posthumously appear on the 1978 album An American Prayer. Even more so than its predecessors, the album is heavily influenced by blues. It was recorded without record producer Paul A. Rothchild after he fell out with the group over the perceived lack of quality of their studio performances. Subsequently, the band co-produced the album with longtime sound engineer Bruce Botnick.', 23, 1, 5),
(31, 'Por este rio acima', 1982, 'Por Este Rio Acima é o sexto álbum de Fausto, editado em 1982, pela Triângulo.\r\nA edição em CD, aconteceu em 1984, pela editora CBS. Entre os artistas que participaram neste trabalhos estão Pedro Caldeira e Júlio Pereira. É o primeiro disco de uma trilogia que inclui ainda os álbuns Crónicas da Terra Ardente (1994) e Em Busco das Montanhas Azuis (2011).\r\nEste Por Este Rio Acima baseia-se nas viagens de Fernão Mendes Pinto, relatadas no seu livro Peregrinação (1614) enquanto que o seguinte, Crónicas da Terra Ardente foi inspirado pela História Trágico-Marítima (1735) reunido por Bernardo Gomes de Brito.', 24, 1, 3),
(32, 'Strange Days', 1967, 'Strange Days is the second studio album by the American rock band the Doors, released on September 25, 1967, by Elektra Records. The album reached number three on the US Billboard 200, and eventually earned RIAA platinum certification. It contains the Top 30 hit singles \"People Are Strange\" and \"Love Me Two Times\".', 23, 1, 19),
(45, 'Por Este Rio Abaixo', 2021, 'Neste novo trabalho, Pedro Mafama faz-se acompanhar por várias figuras do panorama musical nacional, em parcerias colaborativas, salientando a produção geral do álbum, executada lado a lado com Pedro Da Linha, num sucedâneo de canções que contam com abordagens tão díspares de interpretação como de Ana Moura, em “Linda Forma de Morrer”, Profjam em “Cidade Branca”, a co-produção de Branko no tema “Algo Para a Dor”, ou ainda a viagem de “Borboletas da Noite” com Tristany.', 36, 1, 8),
(49, 'DAMN.', 2017, 'DAMN. é o quarto álbum de estúdio do rapper estadunidense Kendrick Lamar. Foi lançado em 14 de abril de 2017, pelas editoras discográficas Top Dawg Entertainment, Aftermath Entertainment e Interscope Records. O disco teve a produção executiva executada por Anthony \"Top Dawg\" Tiffith, Dr. Dre, Sounwave, DJ Dahi, Mike Will Made It e Ricci Riera.\r\nA capa do álbum foi desenhada por Vlad Sepetov, que criou as capas de álbuns dos dois projetos anteriores de Lamar, To Pimp a Butterfly e Untitled Unmastered. ', 40, 1, 10),
(50, 'Currents', 2015, 'Currents é o terceiro álbum de estúdio do projeto de música psicodélica australiano Tame Impala, lançado no dia 17 de Julho de 2015 pela Modular Recordings e pela Universal Music Australia na Austrália, Fiction Records na Europa e pela Interscope Records nos Estado Unidos. Assim como nos álbuns anteriores do projeto, Currents foi escrito, gravado, executado e produzido por Kevin Parker. Pela primeira vez, Parker também foi responsável pela mixagem das músicas e também foi a primeira vez em que Parker gravou todos os instrumentos por conta própria.', 41, 1, 10),
(51, 'Quadrophenia', 1973, 'Quadrophenia is the sixth studio album by the English rock band the Who, released as a double album on 26 October 1973 by Track Records. It is the group\'s second rock opera. Set in London and Brighton in 1965, the story follows a young mod named Jimmy and his search for self-worth and importance. Quadrophenia is the only Who album entirely composed by Pete Townshend. ', 25, 3, 14),
(52, 'Who Are You', 1960, 'asdfasdf', 25, 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artistas`
--

CREATE TABLE `artistas` (
  `id_artistas` int NOT NULL,
  `nome` varchar(45) NOT NULL,
  `descricao` text,
  `ref_id_paises` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `artistas`
--

INSERT INTO `artistas` (`id_artistas`, `nome`, `descricao`, `ref_id_paises`) VALUES
(23, 'The Doors', 'The Doors were an American rock band formed in Los Angeles in 1965, with vocalist Jim Morrison, keyboardist Ray Manzarek, guitarist Robby Krieger, and drummer John Densmore. They were among the most controversial and influential rock acts of the 1960s, mostly due to Morrison\'s lyrics, voice, and his erratic stage persona. They have been cited as one of the pioneers of psychedelia, and the group was widely regarded as an important part of the era.', 239),
(24, 'Fausto', 'Embora nascido a bordo do navio Pátria, em viagem entre Portugal e Angola, Fausto Bordalo Dias foi registado em Vila Franca das Naves, Trancoso. Foi na antiga província ultramarina portuguesa que formou a sua primeira banda, Os Rebeldes. À musicalidade da sua origem beirã, assimilou os ritmos.', 180),
(25, 'The Who', 'The Who are an English rock band formed in London in 1964. Their classic lineup consisted of lead singer Roger Daltrey, guitarist and singer Pete Townshend, bass guitarist and singer John Entwistle, and drummer Keith Moon. They are considered one of the most influential rock bands of the 20th century and have sold over 100 million records worldwide. Their contributions to rock music include the development of the Marshall stack, large PA systems, the use of the synthesizer, Entwistle and Moon\'s influential playing styles, Townshend\'s feedback and power chord guitar technique, and the development of the rock opera. They are cited as an influence by many hard rock, punk rock and mod bands, and their songs still receive regular exposure. ', 238),
(36, 'Pedro Mafama', 'A primeira impressão marcou. Há quase quatro anos, pelas seis da manhã, em noite de aniversário do Lux-Frágil, em Lisboa, preparávamo-nos para abandonar o local e alguém nos tocou nas costas. Tinha algo a dizer. Antes que pudéssemos expor seja o que fosse, já ele argumentava que Lisboa era fado, e era kizomba, e era kuduro, e era hip-hop e era Europa, e era Atlântica e era Árabe, e que tudo isso tanto podia ser conflituoso como ser motivo de celebração.', 180),
(40, 'Kendrick Lamar', 'Kendrick Lamar Duckworth (Compton, 17 de junho de 1987), mais conhecido como Kendrick Lamar, é um rapper, produtor musical e compositor, considerado como um dos artistas mais influentes de sua geração, além de um dos maiores rappers e letristas de todos os tempos.', 239),
(41, 'Tame Impala', 'Tame Impala é um projeto de música psicodélica australiano fundado pelo multi-instrumentista Kevin Parker em 2007. Em estúdio, Parker compõe, grava, executa e produz sozinho as músicas. Em turnês, o projeto tem a formação de banda consistindo em Kevin Parker (guitarra principal e vocais), Jay Watson (sintetizador, vocais de apoio e guitarra), Dominic Simper (guitarra e sintetizador), Cam Avery (baixo e vocais de apoio) e Julien Barbagallo (bateria e vocais de apoio). Anteriormente assinada com a Modular Recordings, o Tame Impala é assinado atualmente pela Interscope Records nos Estados Unidos e pela Fiction Records na Inglaterra. ', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `classificacoes`
--

CREATE TABLE `classificacoes` (
  `id_classificacoes` int NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `classificacoes`
--

INSERT INTO `classificacoes` (`id_classificacoes`, `tipo`) VALUES
(1, 'Muito Mau'),
(2, 'Mau'),
(3, 'Bom'),
(4, 'Muito Bom'),
(5, 'Excelente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `condicoes`
--

CREATE TABLE `condicoes` (
  `id_condicoes` int NOT NULL,
  `condicao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `condicoes`
--

INSERT INTO `condicoes` (`id_condicoes`, `condicao`) VALUES
(1, 'Como Novo'),
(2, 'Muito Bom'),
(3, 'Bom'),
(4, 'Algumas Marcas de Uso'),
(5, 'Bastante Usado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `editoras`
--

CREATE TABLE `editoras` (
  `id_editoras` int NOT NULL,
  `nome` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `editoras`
--

INSERT INTO `editoras` (`id_editoras`, `nome`) VALUES
(1, 'Warner Music Portugal'),
(2, 'Vidisco'),
(3, 'Valentim de Carvalho'),
(4, 'Discos Orfeu'),
(5, 'Abbey Records'),
(6, 'Apple Records'),
(7, 'Universal Music Group'),
(8, 'Sony Music Entertainment'),
(10, 'Interscope'),
(11, 'RCA Records'),
(12, 'Atlantic Records'),
(13, 'Island Records'),
(14, 'Virgin Records'),
(15, 'Def Jam Recordings'),
(16, 'Independent Music Labels'),
(17, 'MCA Records'),
(19, 'Elektra'),
(20, 'Harvest Records');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id_encomendas` int NOT NULL,
  `data` date NOT NULL,
  `ref_id_utilizadores` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`id_encomendas`, `data`, `ref_id_utilizadores`) VALUES
(24, '2021-06-07', 74);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estilos`
--

CREATE TABLE `estilos` (
  `id_estilos` int NOT NULL,
  `tipo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estilos`
--

INSERT INTO `estilos` (`id_estilos`, `tipo`) VALUES
(1, 'Blues'),
(2, 'Bossa Nova'),
(4, 'Clássica'),
(5, 'Country'),
(6, 'Rock Psicadélico'),
(7, 'Disco'),
(8, 'Electrónica'),
(9, 'Fado'),
(10, 'Folk'),
(11, 'Forró'),
(12, 'Funk'),
(13, 'Heavy Metal'),
(14, 'Hip Hop'),
(15, 'House'),
(16, 'Indie'),
(17, 'Instrumental'),
(18, 'Jazz'),
(19, 'MPB'),
(20, 'Pop'),
(21, 'R&B'),
(22, 'Reggae'),
(23, 'Rock Sinfónico'),
(24, 'Rock'),
(25, 'Anos 90'),
(27, 'Música Portuguesa'),
(28, 'Anos 70'),
(30, 'Pop Rock'),
(37, 'Rock Britânico'),
(38, 'Anos 80'),
(39, 'Anos 60'),
(40, 'Música Popular'),
(41, 'Cante Alentejano'),
(42, 'Rap'),
(44, 'Rock 60\'s'),
(45, 'Trap'),
(46, 'Boom bap'),
(47, 'Rock Progressivo'),
(48, 'Hard Rock');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estilos_has_albuns`
--

CREATE TABLE `estilos_has_albuns` (
  `ref_id_estilos` int NOT NULL,
  `ref_id_albuns` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estilos_has_albuns`
--

INSERT INTO `estilos_has_albuns` (`ref_id_estilos`, `ref_id_albuns`) VALUES
(28, 30),
(28, 32),
(8, 45),
(14, 49),
(42, 49),
(6, 50),
(21, 50),
(24, 51),
(28, 51),
(44, 51),
(48, 51),
(2, 52),
(18, 52),
(24, 52),
(37, 52);

-- --------------------------------------------------------

--
-- Estrutura da tabela `guardados`
--

CREATE TABLE `guardados` (
  `ref_id_produtos` int NOT NULL,
  `ref_id_utilizadores` int NOT NULL,
  `guardado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `guardados`
--

INSERT INTO `guardados` (`ref_id_produtos`, `ref_id_utilizadores`, `guardado`) VALUES
(25, 49, 1),
(71, 49, 1),
(71, 72, 1),
(76, 71, 1),
(76, 72, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moradas`
--

CREATE TABLE `moradas` (
  `id_moradas` int NOT NULL,
  `rua` varchar(80) NOT NULL,
  `codigo_postal` varchar(30) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `ref_id_paises` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `moradas`
--

INSERT INTO `moradas` (`id_moradas`, `rua`, `codigo_postal`, `cidade`, `ref_id_paises`) VALUES
(10, 'Largo do Salvador 26', '7830-330', 'Serpa', 180),
(22, 'Rua João Afonso, 17', 'Serpa', '7830-330', 180),
(23, 'Cruz de Pau', '3800-122', 'Seixal', 180),
(24, 'José Bento', '7830-330', 'Serpa', 16),
(25, 'Largo do Salvador 28', '7830-330', 'Serpa', 180),
(26, 'Largo do Salvador 28', '7830-330', 'Serpa', 180),
(27, 'Largo do Salvador 28', 'Serpa', '7830-330', 180),
(28, 'Rua mariaJOsé 12', '3123-201', 'Serpa', 180),
(29, 'Rua José 17', '7830-330', 'Serpa', 180);

-- --------------------------------------------------------

--
-- Estrutura da tabela `paises`
--

CREATE TABLE `paises` (
  `id_paises` int NOT NULL,
  `nome` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paises`
--

INSERT INTO `paises` (`id_paises`, `nome`) VALUES
(1, 'Afghanistan'),
(2, 'Aland Islands'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Bahamas'),
(18, 'Bahrain'),
(19, 'Bangladesh'),
(20, 'Barbados'),
(21, 'Belarus'),
(22, 'Belgium'),
(23, 'Belize'),
(24, 'Benin'),
(25, 'Bermuda'),
(26, 'Bhutan'),
(27, 'Bolivia'),
(28, 'Bonaire, Sint Eustatius and Saba'),
(29, 'Bosnia and Herzegovina'),
(30, 'Botswana'),
(31, 'Bouvet Island'),
(32, 'Brazil'),
(33, 'British Indian Ocean Territory'),
(34, 'Brunei Darussalam'),
(35, 'Bulgaria'),
(36, 'Burkina Faso'),
(37, 'Burundi'),
(38, 'Cambodia'),
(39, 'Cameroon'),
(40, 'Canada'),
(41, 'Cape Verde'),
(42, 'Cayman Islands'),
(43, 'Central African Republic'),
(44, 'Chad'),
(45, 'Chile'),
(46, 'China'),
(47, 'Christmas Island'),
(48, 'Cocos (Keeling) Islands'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Congo'),
(52, 'Congo, Democratic Republic of the Congo'),
(53, 'Cook Islands'),
(54, 'Costa Rica'),
(55, 'Cote D\'Ivoire'),
(56, 'Croatia'),
(57, 'Cuba'),
(58, 'Curacao'),
(59, 'Cyprus'),
(60, 'Czech Republic'),
(61, 'Denmark'),
(62, 'Djibouti'),
(63, 'Dominica'),
(64, 'Dominican Republic'),
(65, 'Ecuador'),
(66, 'Egypt'),
(67, 'El Salvador'),
(68, 'Equatorial Guinea'),
(69, 'Eritrea'),
(70, 'Estonia'),
(71, 'Ethiopia'),
(72, 'Falkland Islands (Malvinas)'),
(73, 'Faroe Islands'),
(74, 'Fiji'),
(75, 'Finland'),
(76, 'France'),
(77, 'French Guiana'),
(78, 'French Polynesia'),
(79, 'French Southern Territories'),
(80, 'Gabon'),
(81, 'Gambia'),
(82, 'Georgia'),
(83, 'Germany'),
(84, 'Ghana'),
(85, 'Gibraltar'),
(86, 'Greece'),
(87, 'Greenland'),
(88, 'Grenada'),
(89, 'Guadeloupe'),
(90, 'Guam'),
(91, 'Guatemala'),
(92, 'Guernsey'),
(93, 'Guinea'),
(94, 'Guinea-Bissau'),
(95, 'Guyana'),
(96, 'Haiti'),
(97, 'Heard Island and Mcdonald Islands'),
(98, 'Holy See (Vatican City State)'),
(99, 'Honduras'),
(100, 'Hong Kong'),
(101, 'Hungary'),
(102, 'Iceland'),
(103, 'India'),
(104, 'Indonesia'),
(105, 'Iran, Islamic Republic of'),
(106, 'Iraq'),
(107, 'Ireland'),
(108, 'Isle of Man'),
(109, 'Israel'),
(110, 'Italy'),
(111, 'Jamaica'),
(112, 'Japan'),
(113, 'Jersey'),
(114, 'Jordan'),
(115, 'Kazakhstan'),
(116, 'Kenya'),
(117, 'Kiribati'),
(118, 'Korea, Democratic People\'s Republic of'),
(119, 'Korea, Republic of'),
(120, 'Kosovo'),
(121, 'Kuwait'),
(122, 'Kyrgyzstan'),
(123, 'Lao People\'s Democratic Republic'),
(124, 'Latvia'),
(125, 'Lebanon'),
(126, 'Lesotho'),
(127, 'Liberia'),
(128, 'Libyan Arab Jamahiriya'),
(129, 'Liechtenstein'),
(130, 'Lithuania'),
(131, 'Luxembourg'),
(132, 'Macao'),
(133, 'Macedonia, the Former Yugoslav Republic of'),
(134, 'Madagascar'),
(135, 'Malawi'),
(136, 'Malaysia'),
(137, 'Maldives'),
(138, 'Mali'),
(139, 'Malta'),
(140, 'Marshall Islands'),
(141, 'Martinique'),
(142, 'Mauritania'),
(143, 'Mauritius'),
(144, 'Mayotte'),
(145, 'Mexico'),
(146, 'Micronesia, Federated States of'),
(147, 'Moldova, Republic of'),
(148, 'Monaco'),
(149, 'Mongolia'),
(150, 'Montenegro'),
(151, 'Montserrat'),
(152, 'Morocco'),
(153, 'Mozambique'),
(154, 'Myanmar'),
(155, 'Namibia'),
(156, 'Nauru'),
(157, 'Nepal'),
(158, 'Netherlands'),
(159, 'Netherlands Antilles'),
(160, 'New Caledonia'),
(161, 'New Zealand'),
(162, 'Nicaragua'),
(163, 'Niger'),
(164, 'Nigeria'),
(165, 'Niue'),
(166, 'Norfolk Island'),
(167, 'Northern Mariana Islands'),
(168, 'Norway'),
(169, 'Oman'),
(170, 'Pakistan'),
(171, 'Palau'),
(172, 'Palestinian Territory, Occupied'),
(173, 'Panama'),
(174, 'Papua New Guinea'),
(175, 'Paraguay'),
(176, 'Peru'),
(177, 'Philippines'),
(178, 'Pitcairn'),
(179, 'Poland'),
(180, 'Portugal'),
(181, 'Puerto Rico'),
(182, 'Qatar'),
(183, 'Reunion'),
(184, 'Romania'),
(185, 'Russian Federation'),
(186, 'Rwanda'),
(187, 'Saint Barthelemy'),
(188, 'Saint Helena'),
(189, 'Saint Kitts and Nevis'),
(190, 'Saint Lucia'),
(191, 'Saint Martin'),
(192, 'Saint Pierre and Miquelon'),
(193, 'Saint Vincent and the Grenadines'),
(194, 'Samoa'),
(195, 'San Marino'),
(196, 'Sao Tome and Principe'),
(197, 'Saudi Arabia'),
(198, 'Senegal'),
(199, 'Serbia'),
(200, 'Serbia and Montenegro'),
(201, 'Seychelles'),
(202, 'Sierra Leone'),
(203, 'Singapore'),
(204, 'Sint Maarten'),
(205, 'Slovakia'),
(206, 'Slovenia'),
(207, 'Solomon Islands'),
(208, 'Somalia'),
(209, 'South Africa'),
(210, 'South Georgia and the South Sandwich Islands'),
(211, 'South Sudan'),
(212, 'Spain'),
(213, 'Sri Lanka'),
(214, 'Sudan'),
(215, 'Suriname'),
(216, 'Svalbard and Jan Mayen'),
(217, 'Swaziland'),
(218, 'Sweden'),
(219, 'Switzerland'),
(220, 'Syrian Arab Republic'),
(221, 'Taiwan, Province of China'),
(222, 'Tajikistan'),
(223, 'Tanzania, United Republic of'),
(224, 'Thailand'),
(225, 'Timor-Leste'),
(226, 'Togo'),
(227, 'Tokelau'),
(228, 'Tonga'),
(229, 'Trinidad and Tobago'),
(230, 'Tunisia'),
(231, 'Turkey'),
(232, 'Turkmenistan'),
(233, 'Turks and Caicos Islands'),
(234, 'Tuvalu'),
(235, 'Uganda'),
(236, 'Ukraine'),
(237, 'United Arab Emirates'),
(238, 'United Kingdom'),
(239, 'United States'),
(240, 'United States Minor Outlying Islands'),
(241, 'Uruguay'),
(242, 'Uzbekistan'),
(243, 'Vanuatu'),
(244, 'Venezuela'),
(245, 'Viet Nam'),
(246, 'Virgin Islands, British'),
(247, 'Virgin Islands, U.s.'),
(248, 'Wallis and Futuna'),
(249, 'Western Sahara'),
(250, 'Yemen'),
(251, 'Zambia'),
(252, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produtos` int NOT NULL,
  `ref_id_albuns` int NOT NULL,
  `ref_id_utilizadores_vendedores` int NOT NULL,
  `ref_id_condicoes` int NOT NULL,
  `ref_id_encomendas` int DEFAULT NULL,
  `img_capa` varchar(255) NOT NULL,
  `preco` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produtos`, `ref_id_albuns`, `ref_id_utilizadores_vendedores`, `ref_id_condicoes`, `ref_id_encomendas`, `img_capa`, `preco`) VALUES
(23, 30, 47, 2, NULL, '74481d83f0b92b27945cefe792fddbb8.webp', '12.90'),
(24, 31, 47, 4, NULL, '72fe60531d88162d8469872a142f8cac.webp', '7.95'),
(25, 32, 48, 4, NULL, '1a95a13fb593755c90912985803985c6.webp', '8.90'),
(71, 45, 65, 1, NULL, '401dbc5d6be065be6298e1d57d83d445.webp', '29.90'),
(76, 49, 69, 3, 24, '0c4e2fd517891c9efdc8a82959f13f5c.webp', '27.90'),
(77, 50, 71, 2, NULL, '0c9e188b4a1c1bcfb8114954238045c6.webp', '37.90'),
(78, 51, 72, 3, NULL, '34ab53d6f3a9c73f242e88ea59e4b5cf.webp', '17.90'),
(79, 52, 74, 1, NULL, '24f07c94e340f5a2a4bf0136471b1e5b.webp', '12.90');

-- --------------------------------------------------------

--
-- Estrutura da tabela `repor_password`
--

CREATE TABLE `repor_password` (
  `id_repor_password` int NOT NULL,
  `ref_id_utilizadores` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `validade` varchar(255) NOT NULL,
  `selector` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `review_albuns`
--

CREATE TABLE `review_albuns` (
  `ref_id_utilizadores` int NOT NULL,
  `ref_id_albuns` int NOT NULL,
  `review` text NOT NULL,
  `ref_id_classificacoes` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `review_albuns`
--

INSERT INTO `review_albuns` (`ref_id_utilizadores`, `ref_id_albuns`, `review`, `ref_id_classificacoes`) VALUES
(48, 45, 'Auto-tune...', 4),
(48, 49, 'To Pimp a Butterfly é melhor..', 3),
(48, 50, 'Não gosto muito.', 2),
(70, 45, 'Ao som de vozes afadistadas em auto-tune, coros digitais, guitarras sintéticas com bombos e baixos que fazem tremer os vidros das casas antigas da Graça, Mouraria e Alfama, somos arrastados ‘Rio Abaixo’ e não ‘Acima’.', 5),
(72, 32, 'Jim Morrison <3', 5),
(72, 45, 'Produção musical de grande qualidade', 4),
(72, 50, 'Álbum fantástico!', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotacoes`
--

CREATE TABLE `rotacoes` (
  `id_rotacoes` int NOT NULL,
  `rpm` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rotacoes`
--

INSERT INTO `rotacoes` (`id_rotacoes`, `rpm`) VALUES
(1, 33),
(2, 45),
(3, 78);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizadores` int NOT NULL,
  `nome` varchar(45) NOT NULL,
  `apelido` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fotoperfil` varchar(255) NOT NULL,
  `telemovel` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `ref_id_moradas` int DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `nif` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizadores`, `nome`, `apelido`, `email`, `password`, `fotoperfil`, `telemovel`, `data_nascimento`, `ref_id_moradas`, `ativo`, `nif`) VALUES
(47, 'Salvador', 'Bentes', 'salvadorbentes@gmail.com', '$2y$10$PCiZDAN6t5u9MANoA.tuKeUyNunP3AGORRyuUx7wAvEH6slJoqhL.', 'a855d8fbf5e75d3331f0252e4960853e.webp', '962484848', '2008-12-10', 10, 1, 250293032),
(48, 'Sílvia', 'Bentes', 'bentesoito@gmail.com', '$2y$10$3v32jzrN52aLinsodfGkhe2oxbRlOdxVWskSWyEjZKVInhwcE4AsG', 'f3660864391d66e9da090562e30be045.webp', '964896997', '1970-05-05', NULL, 1, 250239728),
(49, 'Simão', 'Bentes', 'sdgbentes@gmail.com', '$2y$10$3emuLw75cxf1mbT154BQNeSSznXs9ewYqgR5XY3hmDHeOYUh1Lmly', '1c4060a809f4c5b461f9b2074bdde380.webp', '968014147', '2000-02-06', 22, 1, 250239728),
(65, 'Maria', 'Bentes', 'bentesmaria8@gmail.com', '$2y$10$/KAgfIfUkZ.Dpu4rqZU90.pp1o0IXjWzAgvYls.rEjUvor1VnV.FW', 'a42c784971b20dafa0da3c976787d0c7.webp', '916374849', '1998-08-08', 23, 1, 239432403),
(69, 'Pedro', 'Silva', 'aluno@aluno.com', '$2y$10$f79la30OS3KDTkRqvlwzOurKSXcE3s1Q7sSSB7jpl3If3/vQBeAyW', 'user_default.png', '916374849', '2000-01-01', NULL, 1, 250348234),
(70, 'Vasco', 'Silva', 'vascosilva@gmail.com', '$2y$10$.t2oOWqCTyI/mpbaQ6m/9ufIZ04eUx9V5pxyllWnzfT.id1W.XjWS', '5eeea264b7c9d24c268a988c020b2713.webp', '968014147', '1997-05-15', 25, 1, 250343345),
(71, 'Vítor', 'Silva', 'vitorsilva@gmail.com', '$2y$10$TsooGCn4lmc0ZXJgs3AyzORGCgLttQWtsmUZAGA2VSE0MpAnMwX/.', '3edf3d1619628a8584591bfd0d3978ab.webp', '968234065', '1983-06-16', 26, 1, 250239728),
(72, 'José', 'Esteves', 'estevesjose2021@gmail.com', '$2y$10$UH5qmhuAT0LMY/j4CpKfA.1xXRgnsCfsB4IKqGshtzIUtBy1FxcDa', '18102e40a8b332524d426052ce2e7cbd.webp', '968014147', '1994-06-08', 27, 1, 222222222),
(73, 'zé', 'MAirmsfmA', 'sdfgsdgf@gmail.com', '$2y$10$vZh7yGVxkJQiUlugLrMWnetMU/to/fzvmrlXKP.gFk5WFeDCktvUm', '18faad82ede37b24c7a37f5d52b3e34c.webp', '964896997', '1989-05-17', 28, 1, 234253405),
(74, 'Otília', 'Duarte', 'otiliaduarte2021@gmail.com', '$2y$10$0XTemoaB1J94cWgF5pc11uqFbJ/3.5fkaeU0NO70Lbq0Aj7jkkStm', '0131859fdee1feadcce7e94d116c135b.webp', '968012321', '1998-01-07', 29, 1, 250234502);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `albuns`
--
ALTER TABLE `albuns`
  ADD PRIMARY KEY (`id_albuns`),
  ADD KEY `fk_albuns_artistas1_idx` (`ref_id_artistas`),
  ADD KEY `fk_albuns_rotacoes1_idx` (`ref_id_rotacoes`),
  ADD KEY `fk_albuns_editoras1` (`ref_id_editoras`);

--
-- Índices para tabela `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`id_artistas`),
  ADD KEY `fk_artistas_paises_idx` (`ref_id_paises`);

--
-- Índices para tabela `classificacoes`
--
ALTER TABLE `classificacoes`
  ADD PRIMARY KEY (`id_classificacoes`);

--
-- Índices para tabela `condicoes`
--
ALTER TABLE `condicoes`
  ADD PRIMARY KEY (`id_condicoes`);

--
-- Índices para tabela `editoras`
--
ALTER TABLE `editoras`
  ADD PRIMARY KEY (`id_editoras`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id_encomendas`),
  ADD KEY `fk_encomendas_utilizador1_idx` (`ref_id_utilizadores`);

--
-- Índices para tabela `estilos`
--
ALTER TABLE `estilos`
  ADD PRIMARY KEY (`id_estilos`);

--
-- Índices para tabela `estilos_has_albuns`
--
ALTER TABLE `estilos_has_albuns`
  ADD PRIMARY KEY (`ref_id_estilos`,`ref_id_albuns`),
  ADD KEY `fk_estilos_has_albuns_albuns1_idx` (`ref_id_albuns`),
  ADD KEY `fk_estilos_has_albuns_estilos1_idx` (`ref_id_estilos`);

--
-- Índices para tabela `guardados`
--
ALTER TABLE `guardados`
  ADD PRIMARY KEY (`ref_id_produtos`,`ref_id_utilizadores`),
  ADD KEY `fk_produtos_has_utilizador_utilizador1_idx` (`ref_id_utilizadores`),
  ADD KEY `fk_produtos_has_utilizador_produtos1_idx` (`ref_id_produtos`);

--
-- Índices para tabela `moradas`
--
ALTER TABLE `moradas`
  ADD PRIMARY KEY (`id_moradas`),
  ADD KEY `fk_morada_paises1_idx` (`ref_id_paises`);

--
-- Índices para tabela `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_paises`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produtos`),
  ADD KEY `fk_produtos_albuns1_idx` (`ref_id_albuns`),
  ADD KEY `fk_produtos_condicoes1_idx` (`ref_id_condicoes`),
  ADD KEY `fk_produtos_encomendas1_idx` (`ref_id_encomendas`),
  ADD KEY `fk_produtos_utilizador1_idx` (`ref_id_utilizadores_vendedores`);

--
-- Índices para tabela `repor_password`
--
ALTER TABLE `repor_password`
  ADD PRIMARY KEY (`id_repor_password`),
  ADD KEY `fk_repor_utilizadores1` (`ref_id_utilizadores`);

--
-- Índices para tabela `review_albuns`
--
ALTER TABLE `review_albuns`
  ADD PRIMARY KEY (`ref_id_utilizadores`,`ref_id_albuns`),
  ADD KEY `fk_utilizadores_has_albuns_albuns1_idx` (`ref_id_albuns`),
  ADD KEY `fk_utilizadores_has_albuns_utilizadores1_idx` (`ref_id_utilizadores`),
  ADD KEY `fk_review_albuns_classificacoes1_idx` (`ref_id_classificacoes`);

--
-- Índices para tabela `rotacoes`
--
ALTER TABLE `rotacoes`
  ADD PRIMARY KEY (`id_rotacoes`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizadores`),
  ADD KEY `fk_utilizador_morada1_idx` (`ref_id_moradas`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `albuns`
--
ALTER TABLE `albuns`
  MODIFY `id_albuns` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `artistas`
--
ALTER TABLE `artistas`
  MODIFY `id_artistas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `classificacoes`
--
ALTER TABLE `classificacoes`
  MODIFY `id_classificacoes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `condicoes`
--
ALTER TABLE `condicoes`
  MODIFY `id_condicoes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `editoras`
--
ALTER TABLE `editoras`
  MODIFY `id_editoras` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id_encomendas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `estilos`
--
ALTER TABLE `estilos`
  MODIFY `id_estilos` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `moradas`
--
ALTER TABLE `moradas`
  MODIFY `id_moradas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `paises`
--
ALTER TABLE `paises`
  MODIFY `id_paises` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produtos` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de tabela `repor_password`
--
ALTER TABLE `repor_password`
  MODIFY `id_repor_password` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `rotacoes`
--
ALTER TABLE `rotacoes`
  MODIFY `id_rotacoes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizadores` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `albuns`
--
ALTER TABLE `albuns`
  ADD CONSTRAINT `fk_albuns_artistas1` FOREIGN KEY (`ref_id_artistas`) REFERENCES `artistas` (`id_artistas`),
  ADD CONSTRAINT `fk_albuns_editoras1` FOREIGN KEY (`ref_id_editoras`) REFERENCES `editoras` (`id_editoras`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_albuns_rotacoes1` FOREIGN KEY (`ref_id_rotacoes`) REFERENCES `rotacoes` (`id_rotacoes`);

--
-- Limitadores para a tabela `artistas`
--
ALTER TABLE `artistas`
  ADD CONSTRAINT `fk_artistas_paises` FOREIGN KEY (`ref_id_paises`) REFERENCES `paises` (`id_paises`);

--
-- Limitadores para a tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `fk_encomendas_utilizador1` FOREIGN KEY (`ref_id_utilizadores`) REFERENCES `utilizadores` (`id_utilizadores`);

--
-- Limitadores para a tabela `estilos_has_albuns`
--
ALTER TABLE `estilos_has_albuns`
  ADD CONSTRAINT `fk_estilos_has_albuns_albuns1` FOREIGN KEY (`ref_id_albuns`) REFERENCES `albuns` (`id_albuns`),
  ADD CONSTRAINT `fk_estilos_has_albuns_estilos1` FOREIGN KEY (`ref_id_estilos`) REFERENCES `estilos` (`id_estilos`);

--
-- Limitadores para a tabela `guardados`
--
ALTER TABLE `guardados`
  ADD CONSTRAINT `fk_produtos_has_utilizador_produtos1` FOREIGN KEY (`ref_id_produtos`) REFERENCES `produtos` (`id_produtos`),
  ADD CONSTRAINT `fk_produtos_has_utilizador_utilizador1` FOREIGN KEY (`ref_id_utilizadores`) REFERENCES `utilizadores` (`id_utilizadores`);

--
-- Limitadores para a tabela `moradas`
--
ALTER TABLE `moradas`
  ADD CONSTRAINT `fk_morada_paises1` FOREIGN KEY (`ref_id_paises`) REFERENCES `paises` (`id_paises`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_albuns1` FOREIGN KEY (`ref_id_albuns`) REFERENCES `albuns` (`id_albuns`),
  ADD CONSTRAINT `fk_produtos_condicoes1` FOREIGN KEY (`ref_id_condicoes`) REFERENCES `condicoes` (`id_condicoes`),
  ADD CONSTRAINT `fk_produtos_encomendas1` FOREIGN KEY (`ref_id_encomendas`) REFERENCES `encomendas` (`id_encomendas`),
  ADD CONSTRAINT `fk_produtos_utilizador1` FOREIGN KEY (`ref_id_utilizadores_vendedores`) REFERENCES `utilizadores` (`id_utilizadores`);

--
-- Limitadores para a tabela `repor_password`
--
ALTER TABLE `repor_password`
  ADD CONSTRAINT `fk_repor_utilizadores1` FOREIGN KEY (`ref_id_utilizadores`) REFERENCES `utilizadores` (`id_utilizadores`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `review_albuns`
--
ALTER TABLE `review_albuns`
  ADD CONSTRAINT `fk_review_albuns_classificacoes1` FOREIGN KEY (`ref_id_classificacoes`) REFERENCES `classificacoes` (`id_classificacoes`),
  ADD CONSTRAINT `fk_utilizadores_has_albuns_albuns1` FOREIGN KEY (`ref_id_albuns`) REFERENCES `albuns` (`id_albuns`),
  ADD CONSTRAINT `fk_utilizadores_has_albuns_utilizadores1` FOREIGN KEY (`ref_id_utilizadores`) REFERENCES `utilizadores` (`id_utilizadores`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `fk_utilizador_morada1` FOREIGN KEY (`ref_id_moradas`) REFERENCES `moradas` (`id_moradas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
