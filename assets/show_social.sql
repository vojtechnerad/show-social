-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: db.dw175.webglobe.com
-- Vytvořeno: Stř 06. pro 2023, 03:34
-- Verze serveru: 10.5.22-MariaDB-1:10.5.22+maria~ubu2004-log
-- Verze PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `show_social`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `bookmarked_movies`
--

CREATE TABLE `bookmarked_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `bookmarked_movies`
--

INSERT INTO `bookmarked_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 19995, '2023-09-06 13:47:56'),
(1, 76600, '2023-04-25 01:36:04'),
(1, 106646, '2023-05-22 03:35:43'),
(1, 181808, '2023-08-10 21:52:28'),
(1, 385687, '2023-06-13 06:41:44'),
(1, 447365, '2023-05-11 21:09:28'),
(1, 502356, '2023-04-18 23:23:44'),
(1, 569094, '2023-06-13 03:30:58'),
(1, 603692, '2023-04-19 16:05:03'),
(1, 677179, '2023-04-18 23:23:50'),
(1, 700391, '2023-04-19 17:31:20'),
(3, 76600, '2023-04-18 23:27:36'),
(3, 594767, '2023-06-13 03:45:46'),
(3, 677179, '2023-04-18 23:27:34'),
(3, 700391, '2023-04-18 23:27:38'),
(13, 713704, '2023-05-22 00:01:34');

-- --------------------------------------------------------

--
-- Struktura tabulky `bookmarked_tv_shows`
--

CREATE TABLE `bookmarked_tv_shows` (
  `user_id` int(11) NOT NULL,
  `show_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `bookmarked_tv_shows`
--

INSERT INTO `bookmarked_tv_shows` (`user_id`, `show_id`, `timestamp`) VALUES
(1, 456, '2023-04-18 23:17:10'),
(1, 19384, '2023-04-18 23:16:53'),
(1, 67744, '2023-04-18 23:16:59'),
(1, 88329, '2023-04-18 23:16:47'),
(1, 94605, '2023-04-18 23:16:57'),
(1, 95396, '2023-05-22 04:14:02'),
(1, 114461, '2023-09-28 22:55:57'),
(3, 82856, '2023-04-18 23:54:03'),
(3, 85328, '2023-04-19 00:39:04'),
(3, 100088, '2023-04-19 00:09:30'),
(3, 196080, '2023-04-18 23:27:47'),
(3, 209085, '2023-04-19 00:38:41'),
(13, 215315, '2023-05-22 03:08:28'),
(14, 19077, '2023-05-22 20:53:16'),
(15, 84958, '2023-11-09 20:32:19'),
(16, 1418, '2023-11-10 19:19:13'),
(20, 97645, '2023-11-15 23:02:16'),
(22, 88808, '2023-11-30 13:34:27'),
(23, 79680, '2023-12-02 16:41:50');

-- --------------------------------------------------------

--
-- Struktura tabulky `favorite_movies`
--

CREATE TABLE `favorite_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `favorite_movies`
--

INSERT INTO `favorite_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 767, '2023-04-27 06:37:50'),
(1, 75023, '2023-06-09 12:53:25'),
(1, 76600, '2023-04-25 01:36:04'),
(1, 106646, '2023-05-22 03:35:41'),
(1, 181808, '2023-08-10 21:52:29'),
(1, 447365, '2023-05-11 21:09:32'),
(1, 569094, '2023-06-13 03:38:16'),
(1, 594767, '2023-05-22 04:00:21'),
(1, 603692, '2023-04-19 13:35:31'),
(1, 700391, '2023-04-19 13:24:58'),
(3, 76600, '2023-04-19 00:08:25'),
(3, 594767, '2023-06-13 03:45:46'),
(3, 677179, '2023-04-19 00:08:33'),
(13, 713704, '2023-05-22 00:01:34'),
(15, 27205, '2023-11-09 20:31:09'),
(16, 76600, '2023-11-10 19:16:07'),
(20, 872585, '2023-11-15 23:01:54'),
(22, 76600, '2023-11-30 13:30:35'),
(23, 872585, '2023-12-02 16:40:41');

-- --------------------------------------------------------

--
-- Struktura tabulky `favorite_tv_shows`
--

CREATE TABLE `favorite_tv_shows` (
  `user_id` int(11) NOT NULL,
  `show_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `favorite_tv_shows`
--

INSERT INTO `favorite_tv_shows` (`user_id`, `show_id`, `timestamp`) VALUES
(1, 82856, '2023-06-12 08:40:26'),
(1, 94605, '2023-05-29 10:10:15'),
(1, 100088, '2023-04-27 06:43:26'),
(3, 82856, '2023-04-18 23:54:04'),
(3, 85328, '2023-04-19 00:39:04'),
(3, 95396, '2023-05-22 04:14:09'),
(3, 100088, '2023-04-19 00:09:29'),
(3, 203057, '2023-04-19 00:00:55'),
(3, 215103, '2023-06-13 03:46:03'),
(8, 4194, '2023-05-22 04:05:36'),
(13, 215315, '2023-05-22 03:08:27'),
(14, 221949, '2023-05-22 20:51:48');

-- --------------------------------------------------------

--
-- Struktura tabulky `friendslist`
--

CREATE TABLE `friendslist` (
  `requesterId` int(11) NOT NULL,
  `adresseeId` int(11) NOT NULL,
  `isConfirmed` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `friendslist`
--

INSERT INTO `friendslist` (`requesterId`, `adresseeId`, `isConfirmed`, `timestamp`) VALUES
(1, 2, 1, '2023-04-13 22:30:32'),
(1, 6, 0, '2023-04-13 21:37:42'),
(1, 7, 0, '2023-04-13 21:37:22'),
(1, 11, 0, '2023-04-13 21:37:18'),
(1, 13, 0, '2023-05-22 03:07:06'),
(1, 15, 0, '2023-11-09 20:39:47'),
(1, 17, 0, '2023-11-20 21:07:21'),
(1, 20, 1, '2023-11-15 23:08:50'),
(3, 1, 1, '2023-06-13 03:33:57'),
(3, 2, 1, '2023-04-05 04:07:20'),
(5, 1, 1, '2023-04-27 06:46:00'),
(8, 1, 1, '2023-06-09 19:03:18'),
(16, 13, 0, '2023-11-10 19:20:01');

-- --------------------------------------------------------

--
-- Struktura tabulky `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `original_title` varchar(100) NOT NULL,
  `overview` varchar(1000) NOT NULL,
  `poster_path` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  `runtime` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `original_title`, `overview`, `poster_path`, `release_date`, `runtime`) VALUES
(496, 'Borat: Nakoukání do amerycké kultůry na obědnávku slavnoj kazašskoj národu', 'Borat: Cultural Learnings of America for Make Benefit Glorious Nation of Kazakhstan', 'Borat Sagdijev je šestým nejznámějším Kazachem a nejlepším televizním reportérem Kazašské státní televize, která ho vyšle do USA, aby zde natočil dokument o této „zemi neomezených možností“. A případně si našel novou manželku, protože tu starou tlustou mu znásilnil a roztrhal medvěd.  Cohen s filmovým štábem putuje po Spojených státech a uvádí do rozpaků nic netušící lidi, kteří se domnívají, že jsou svědky natáčení skutečného dokumentu pro kazašskou televizi. Cohen jde ovšem tentokrát v drsnosti a politické nekorektnosti svého humoru mnohem dál, než bylo možné v televizní show. Nebude ušetřen nikdo!', '/kfkyALfD4G1mlBJI1lOt2QCra4i.jpg', '2006-11-01', 84),
(671, 'Harry Potter a Kámen mudrců', 'Harry Potter and the Philosopher\'s Stone', 'Harry Potter se v den svých jedenáctých narozenin dozvídá, že je osiřelým synem dvou velkých kouzelníků a sám má magické schopnosti. Na Škole čar a kouzel v Bradavicích se Harry mimo jiné naučí hrát famfrpál na létajícím koštěti a sehraje vzrušující šachovou partii s živými figurami, aby se mohl postavit Tomu, jehož jméno se nesmí vyslovit, který je odhodlán ho zahubit.', '/2EpqAuG2ES1GCSx6Ggbi9RL5c53.jpg', '2001-11-16', 152),
(672, 'Harry Potter a Tajemná komnata', 'Harry Potter and the Chamber of Secrets', 'Harry Potter se po prázdninách vrací do Bradavic a nastupuje do druhého ročníku. A to i přes varování domácího skřítka Dobbyho, podle kterého mu v čarodějné škole hrozí smrt. Harry nedbá nářků skřítka působícího víc škody než užitku, ale potom se skutečně začnou dít podivné věci, na stěnách se objevují neznámé nápisy a několik studentů je přepadeno tajemným přízrakem. Co s tím má společného Tajemná komnata? Stojí za spiknutím opět Voldemort? Kdo je Zmijozelův dědic? Záhadu se Harry vydává rozluštit společně se svými starými známými – Ronem a Hermionou.', '/676E2pDMxqFOPAV9RWjFrRNa5n0.jpg', '2002-11-13', 161),
(674, 'Harry Potter a Ohnivý pohár', 'Harry Potter and the Goblet of Fire', 'Když se z Ohnivého poháru vynoří jméno Harryho Pottera, stane se soutěžícím ve vyčerpávající bitvě o slávu mezi třemi kouzelnickými školami: Turnaji tří kouzelníků. Jenže Harry se do soutěže nepřihlásil – kdo to udělal za něj? Teď musí Harry čelit smrtelně nebezpečnému drakovi, divokým vodním démonům a ocitne se v začarovaném bludišti, aby se nakonec objevil v kruté společnosti Toho, jehož jméno nesmí být vysloveno.', '/eMiMOEdZ6M3fEkXCwCnQQa1Pxkh.jpg', '2005-11-16', 157),
(767, 'Harry Potter a Princ dvojí krve', 'Harry Potter and the Half-Blood Prince', 'Povzbuzeni návratem Lorda Voldemorta působí Smrtijedi spoušť jak ve světě mudlů, tak ve světě kouzelníků a Bradavice už dávno nejsou tím bezpečným místem, jakým kdysi bývaly. Harry má podezření, že nebezpečí je přímo v Bradavicích, ale Brumbál se soustředí na přípravu na poslední bitvu, která se rychle blíží. Potřebuje, aby mu Harry pomohl odkrýt důležitý klíč, který vede k rozuzlení Voldemortovy obrany – rozhodující informaci ale zná jen bývalý bradavický profesor Horác Křiklan. Vědom si toho přiměje Brumbál svého starého kolegu, aby se vrátil na své staré místo, a slíbí mu vyšší plat, větší kancelář a navíc možnost učit slavného Harryho Pottera.Mezitím útočí na studenty ještě úplně jiný nepřítel – teenagerovské hormony. Harryho dlouhodobé přátelství s Ginny Weasleyovou přerůstá v hlubší city, ale v cestě stojí její přítel, Dean Thomas, a to nemluvě o jejím velkém bratru Ronovi.', '/2TbTfI93E77GT0gF6AkRAqICTrr.jpg', '2009-07-07', 147),
(1771, 'Captain America: První Avenger', 'Captain America: The First Avenger', 'Steve Rogers je idealistický mladík, který stejně jako drtivá většina jeho vrstevníků touží vstoupit do armády, aby mohl pomoci zdolat nacisty, až se jeho země zapojí do Druhé světové války. Jenže nemá sebemenší šanci, protože je podměrečný a neduživý a jediným jeho předpokladem je zarputilost, s jakou se nechává opakovaně vyhazovat od odvodových komisí. Ta ve finále rozhodne o tom, že ho vyberou jako vhodného kandidáta pro vědecký experiment, který má produkovat Supervojáky. Jeho premiéra se vydaří a ze Stevea se díky vědeckému týmu vedeném Dr. Erskinem stane dokonalá lidská bytost. Na boj s nacisty přesto nedojde, protože se zjeví mnohem nebezpečnější nepřítel. Tajná organizace HYDRA, vedená všehoschopným gaunerem Johannem Schmidtem, totiž začala spřádat vlastní plány na ovládnutí světa. Steve Rogers dostane štít, který se stane jeho poznávacím znamením, skupinku schopných parťáků a vyrazí do mise, která mu může zajistit nesmrtelnost. Nebo přinést smrt.', '/ym0xcdKmMKDJZrQxpDjPJMs5dKV.jpg', '2011-07-22', 125),
(1893, 'Star Wars: Epizoda I - Skrytá hrozba', 'Star Wars: Episode I - The Phantom Menace', 'Galaktickou republikou zmítají nepokoje. Vznikly spory ohledně zdanění obchodních cest k odlehlým hvězdným soustavám. Chamtivá Obchodní federace doufá, že záležitost vyřeší její armáda bojových droidů, která začne úplnou blokádu malé planety Naboo. Zatímco Republikový kongres vede o těchto dramatických událostech zdlouhavé rozhovory, Nejvyšší kancelář tajně vyšle dva rytíře Jedi, ochránce míru a spravedlnosti v galaxii, aby konflikt zažehnali...', '/g0fFRDE3yrgm44dBY1n4PvnNlhh.jpg', '1999-05-19', 136),
(10681, 'VALL-I', 'WALL·E', 'Film začíná v roce 2700. Poslední operační stroj VALL-I stále plní úkol čištění Země se svým jediným mazlíčkem – švábem Halem, který mu dělá společnost. Malý robot, roztomilý a působivý, si za ta léta docela vyvinul svou osobnost. Bydlí v maringotce plné zvláštností a artefaktů z lidského života jako je Rubikova kostka, kuchyňský šlehač a jeho největší poklad – stará video kazeta s filmem Hello Dolly. Během začátku filmu si přidá do své sbírky novou věc – malou rostlinku, kterou zasadí do staré boty. Jednoho dne jde VALL-I po své obvyklé práci, ale blízko přistane kosmická loď. Kosmická loď vyšle malou, létající robotku Eve, která začíná na povrchu planety něco hledat. VALL-I se beznadějně zamiluje. Rodinná animovaná pohádka ze studia Pixar.', '/3HROKmgDPGWDeZQrqWBRd7URVMA.jpg', '2008-06-22', 98),
(12444, 'Harry Potter a Relikvie smrti – část 1', 'Harry Potter and the Deathly Hallows: Part 1', 'Harry, Ron a Hermiona se vydávají na nebezpečnou misi, jejímž cílem je najít a zničit tajemství Voldemortovy nesmrtelnosti - viteály. Spoléhat musí jen sami na sebe, a to víc, než kdy dříve, protože jim už profesoři nepomohou. Navíc jsou mezi nimi temné síly, které se je snaží rozdělit. Mezitím se svět kouzelníků stane nebezpečným místem pro všechny nepřátele Pána zla. Dlouho obávaná válka se zlem začala, Voldemortovi smrtijedi kontrolují ministerstvo kouzel i Bradavice a terorizují a zatýkají všechny, kdo by se jim chtěl postavit. To nejcennější, co Voldemort chce, ale stále hledají: Harryho Pottera. Vyvolený se stal loveným. Smrtijedi hledají Harryho všude, aby ho podle příkazu Voldemorta přivedli... živého. Harryho jedinou nadějí je, že najde viteály dřív, než Voldemort najde jeho. Při pátrání po viteálech objeví starý a téměř zapomenutý příběh - legendu o relikviích smrti. A pokud je legenda pravdivá, mohl by Voldemort získat neomezenou moc a sílu, po které touží.', '/silXNP7hsvRKkqbaIYvUySuyWhQ.jpg', '2010-11-17', 146),
(19995, 'Avatar', 'Avatar', 'Příběh se odehrává v budoucnosti na planetě Pandora, kde lidé ze Země objeví vzácnou horninu unobtanium a rozhodnou se ji vytěžit. V cestě jim však stojí místní domorodci Na’vi. Aby pozemšťané získali jejich důvěru, vytvoří umělé tvory „avatary“, kteří vzhledem odpovídají obyvatelům planety, ale je do nich přenášeno lidské vědomí. Hlavní hrdina, ochrnutý mariňák Jake, se tak v zapůjčené podobě dostává k místnímu kmeni Omaticaya. Brzy prohlédne zpupné chování lidí, pozná kouzlo života v symbióze s přírodou a zamiluje se do dcery náčelníka Neytiri. V rozhodujícím boji o budoucnost planety se proto postaví na stranu Na’vi.', '/q6ilgi1VzOMYRhcGEdYNBD3Lm5O.jpg', '2009-12-15', 162),
(24428, 'Avengers', 'The Avengers', 'Marvel Studio uvádí \"Marvelovské mstitele\" - super hrdinský tým všech dob, který přestaví ikonické super hrdiny - Iron Mana, Neuvěřitelného Hulka, Thora, Captaina Americu, Hawkeye a Black Widow. Když se objeví nečekaný nepřítel, který ohrožuje světovou bezpečnost a bezpečí , Nick Fury, ředitel mezinárodní mírové agentury známé také jako S.H.I.E.L.D., zjistí, že potřebuje tým, aby odvrátil světovou katastrofu. Začíná provádět nábor po celém světě.', '/jEQswViXNu2PvUvWzQoxhKjQc3p.jpg', '2012-04-25', 142),
(27205, 'Počátek', 'Inception', 'Sny jsou branou k podvědomí člověka, branou jeho k nejtajnějším myšlenkám a touhám. V lidské mysli se skrývají tajemství nepoznaného, věcí, které ještě nevznikly, věcí, které ještě nikdo nevymyslel. A ve světě, kde je myšlenka tím nejmocnějším hybatelem je tím nejdůležitějším ukrást ji. Dom Cobb je ve svém oboru špička. Dokáže zcizit jakékoliv tajemství, jakoukoliv informaci z podvědomí během spánku dané osoby, kdy je mysl nejvíce oslabena. Takový život z něj však udělal uprchlíka, štvance ve světě, kde se za tyto zločiny platí hlavou a kde firemní špionáž nabrala nové nevídané rozměry.', '/bgIt92V3IDysoAIcEfOo2ZK9PEv.jpg', '2010-07-15', 148),
(33380, 'Gayniggers from Outer Space', 'Gayniggers from Outer Space', '', '/eEsWxnpMb4buLKMizxXHI0ZKxyA.jpg', '1992-01-01', 26),
(36993, 'Slunce, seno a pár facek', 'Slunce, seno a pár facek', 'Již podruhé jsme zavítali do jihočeských Hoštic, abychom sledovali osud Konopníků a Škopků. Nahlédneme do vztahu mezi těhotnou Blaženou a Vencou, kolem kterého zhrzená Milada z hospody rozšíří fámy. Vzniká skandál a hotová bitva mezi jejich rodinami. Ve stejném duchu probíhá vztah mezi živočichářem Bédou a účetní JZD Evičkou.', '/n7MSy0Z9R9JaLIZTdLpnAbOZVSA.jpg', '1989-07-01', 127),
(36994, 'Slunce, seno, jahody', 'Slunce, seno, jahody', 'Všechno začíná v okamžiku, kdy se do jihočeské vísky Hoštice přichází student vysoké zemědělské školy Šimon Plánička, aby nastoupil v místním JZD na brigádu a současně se pokusil prověřit v praxi svůj experiment na téma \"dojivost krav v závislosti na kultuře prostředí.\" Vedení JZD však nechce o pochybném experimentu ani slyšet. Všechno se však změní v okamžiku, kdy se po vesnici rozkřikne, že je Šimon synem předsedy krajské zemědělské správy, také se totiž jmenuje Plánička. Blažena, dcera paní Škopkové u níž je Šimon ubytován dostane za úkol vypátrat, jak se věci mají. Všechno však komplikuje žárlivost Blaženina kluka Vency. Film musel být před uvedením do distribuce pro kina zkrácen o deset minut.', '/kKlBTBqRoV7pX2utkWvFSmQqPal.jpg', '1983-09-01', 83),
(64690, 'Jízda nadoraz', 'Drive', 'Říkají mu Řidič. Přes den je filmovým kaskadérem, po nocích si přivydělává jako nájemný řidič zločineckých gangů. Nezajímá ho o jakou práci ten večer zrovna jde, řítí se nocí s policejními vozy v zádech. Shannon je Řidičovým učitelem i manažerem, který se ho snaží dohazovat filmovým režisérům i zlodějům, kteří za něj jsou ochotni dobře zaplatit. Shannon má v plánu koupi vozu, ve kterém by se Řidič mohl zúčastnit profesionálních závodů. Navrhne, aby se investorem stal Bernie Rose, místní boháč s pochybnými zdroji příjmů. Samotářskému a ze svého dvojího života značně rozpolcenému Řidiči zcela změní život náhodné setkání se sousedkou Irene, se kterou tráví stále více času. Vše se však změní když je z vězění propuštěn Irenin manžel Standard. Řidič se s ním domluví na poslední loupeži, která Standardovi umožnit splatit dluh, kvůli kterému ho vydírají gangsteři. Ukáže se však, že šlo o nastraženou past.', '/602vevIURmpDfzbnv5Ubi6wIkQm.jpg', '2011-09-15', 101),
(67717, 'Hard Bounty', 'Hard Bounty', '', '/yy35crQiGb3RXhzSAv8LJqQUN0x.jpg', '1995-06-01', 88),
(75023, '„Marečku, podejte mi pero!“', '„Marečku, podejte mi pero!“', 'Jiří Kroupa, mistr v továrně na zemědělské stroje, by mohl povýšit - musel by ovšem vystudovat večerní průmyslovku. Pan Kroupa se tomu vehementně brání, nakonec však podlehne naléhání členů dílenského výboru a na školu se dá zapsat. Stejný vzdělávací ústav navštěvuje i jeho syn, přes den dokonce sedává v téže lavici. Náhle se ukazuje, že tatínek má mnohem horší prospěch než jeho ratolest. Dokáže si rodič napravit reputaci a obstát před profesory i spolužáky?', '/eINA2AN1ST3Iti7O8BWK7VSorxt.jpg', '1976-10-08', 93),
(76600, 'Avatar: The Way of Water', 'Avatar: The Way of Water', 'Se po více jak deseti letech znovu setkáváme s Jackem Sully, Neytiri a jejich dětmi, kteří stále bojují za to, aby se udrželi v bezpečí a naživu.', '/yXLr49f3kNFrgUZpLrTA0M2yHTx.jpg', '2022-12-14', 192),
(106646, 'Vlk z Wall Street', 'The Wolf of Wall Street', 'Jordan Belfort, americký broker, podnikatel a spisovatel, začínal jako ambiciózní makléř z Wall Street, adaptoval se na „vlčí\" podmínky obchodů na trhu a rychle se prosadil coby nejlepší prodejce akcií, vydělávající sedmdesát tisíc měsíčně. Stal se asertivním šéfem, experimentujícím s drogami, dívkami lehkých mravů i s vlastním životem. Rychlá auta, krásné ženy ani drogy mu nestačily. Kvůli čemu je ještě člověk ochoten hazardovat se šťastným manželstvím, kariérou nebo dokonce s osobní svobodou?', '/di5Cs1uex5RPwJNzNsJS30fhCxT.jpg', '2013-12-25', 180),
(181808, 'Star Wars: Poslední z Jediů', 'Star Wars: The Last Jedi', 'Superzbraň Hvězda smrti byla zničena, zároveň tím ale byla odhalena poloha základny Odboje vedeného generálkou Leiou na planetě D’Qar. Členové odboje za podpory stíhacích pilotů se chystají na rozsáhlou evakuaci. Nejvyšší vůdce Snoke z Prvního řádu na ně vysílá obrovskou flotilu pod velením generála Huxe a svého učedníka Kyla Rena, který nedávno zabil svého otce Hana Sola. Mezitím mladá Rey odlétá za Lukem Skywalkerem do chrámu Jediů na okraji galaxie a prosí ho o pomoc. Věří, že se mistr vrátí a vnese do boje jiskru naděje. Snoke propojuje mysl svého temného adepta Kyla a Rey. Ti teď telepaticky komunikují napříč galaxií. Jeden druhého se snaží získat na svoji stranu. Kylo odhaluje dívce, co se stalo mezi ním a Lukem a co ho přimělo dát se na stranu temna. Rey je přesvědčena, že se Kylo může vrátit na stranu dobra, a odlétá za ním…', '/zVCnE1hte1sxQUfPCq63tqMYewG.jpg', '2017-12-13', 150),
(300619, 'Ada', 'Ada', '', '/qQODYXWm78usLF6jCZtCKVWZbYw.jpg', '1988-04-18', 64),
(315162, 'Kocour v botách: Poslední přání', 'Puss in Boots: The Last Wish', 'Kocour v botách zjišťuje, že jeho vášeň pro dobrodružství si vybrala svou daň: už přišel o osm ze svých devíti životů. A tak se vydává na výpravu za bájným Posledním přáním, aby svých devět životů zase obnovil.', '/7eTzBZaKUInBtpUe0BuJ9z0WHIL.jpg', '2022-12-07', 103),
(385687, 'Rychle a zběsile 10', 'Fast X', 'Když jste si mysleli, že na světě už není nikdo, kdo by dostal ten hloupý nápad, že by chtěl dohonit a předhonit Dominica Toretta, objevila se jich celá řada...', '/dNHTCruUWuK47FtfOYvd1woj6CG.jpg', '2023-05-17', 142),
(447365, 'Strážci Galaxie: Volume 3', 'Guardians of the Galaxy Vol. 3', 'Ve snímku Strážci Galaxie: Volume 3 od Marvel Studios se oblíbená parta vesmírných ztroskotanců zabydluje na Kdovíkde. Jejich spokojený život však brzy naruší ozvěny Rocketovy bouřlivé minulosti. Peter Quill, který se stále trápí ztrátou milované Gamory, musí vypravit svůj tým na nebezpečnou misi s cílem zachránit Rocketův život, přičemž nezdar v této misi může znamenat konec Strážců tak, jak je známe.', '/nRES3Hful5IoGniTDPmQLFPv4rz.jpg', '2023-05-03', 150),
(502356, 'Super Mario Bros. ve filmu', 'The Super Mario Bros. Movie', 'Mario a Luigi, legendární Super Mario Bros., se konečně dočkali svého filmu! Nejslavnější a nejkníratější instalatér na světě se vydává za dobrodružstvím do světa plného fantazie a kouzel, který bude muset zachránit  před nenasytným netvorem. Protože kdo jiný by to zvládl?', '/AlvvnaLaaSLNQzHo5bd4VadncPJ.jpg', '2023-04-05', 92),
(569094, 'Spider-Man: Napříč paralelními světy', 'Spider-Man: Across the Spider-Verse', 'Miles Morales vrací v další kapitole Spider-Verse ságy. Čeká na něj epické dobrodružství, které přátelského souseda Spider-Mana transportuje z Brooklynu napříč mnohovesmírem, aby pomohl Gwen Stacey a nové skupině Spider-lidí proti padouchovi silnějšímu než cokoliv, proti čemu se v minulosti postavili.', '/qLUNJM8AjrxzcJxtLW0uW7HhX5K.jpg', '2023-05-31', 140),
(593643, 'Menu', 'The Menu', 'Mladý pár cestuje na odlehlý ostrov, aby se najedl v luxusní restauraci, kde šéfkuchař připravil bohaté menu s několika šokujícími překvapeními.', '/zA9X8DpLSctaQvDvXPnm1RY2XZR.jpg', '2022-11-17', 107),
(594767, 'Shazam! Hněv bohů', 'Shazam! Fury of the Gods', 'Billy Batson a jeho nevlastní sourozenci se stále učí skloubit životy teenagerů s kariérou superhrdinů. Když na Zemi ale dorazí trojice prastarých pomstychtivých bohyň, Billy a jeho rodina jsou vrženi do boje nejen o superschopnosti, ale i životy jich samých i celého světa.', '/gi7MmM19OKGvOw8xEnGSFvPCu2k.jpg', '2023-03-15', 130),
(603692, 'John Wick: Kapitola 4', 'John Wick: Chapter 4', 'John Wick odhalí cestu, jak porazit Nejvyšší radu. Než se mu však podaří získat svobodu, musí čelit novému nepříteli, který má mocné spojence po celém světě. Bude to o to težší, že nová spojenectví mění staré přátele v nepřátele...', '/sIQ9Lqw1QVZPq4tVgbPcPoE38GM.jpg', '2023-03-22', 170),
(638974, 'Vražda v Paříži', 'Murder Mystery 2', 'Z Nicka a Audrey Spitzových jsou soukromá očka na plný úvazek. Po jejich příteli se slehne zem a oni se připletou k mezinárodnímu pátrání po jeho únosci.', '/5wpVy0KUWzDKDKgrayM0Q8lXOiK.jpg', '2023-03-28', 91),
(640146, 'Ant-Man a Wasp: Quantumania', 'Ant-Man and the Wasp: Quantumania', 'Scott Lang a Hope Van Dyne spolu s Hankem Pymem a Janet Van Dyne prozkoumávají Quantum Realm, kde interagují s podivnými tvory a vydávají se na dobrodružství, které přesahuje hranice toho, co považovali za možné.', '/jgyhDWuiqD9HNwteJ7TRaOHK3u.jpg', '2023-02-15', 125),
(670292, 'Stvořitel', 'The Creator', 'Uprostřed války v budoucnosti mezi lidskou rasou a silami umělé inteligence je Joshua, zocelený bývalý agent speciálních jednotek, který truchlí nad zmizením své ženy, naverbován, aby vypátral a zabil Stvořitele, nepolapitelného architekta pokročilé umělé inteligence, který vyvinul záhadnou zbraň s mocí ukončit válku... a lidstvo samotné.  Joshua a jeho tým elitních agentů se vydávají přes nepřátelské linie do temného centra území okupovaného AI... jen aby zjistili, že zbraň, která má zničit svět, je AI v podobě malého dítěte.', '/vOrL88iQSoOWEptPqshwcr1fzw6.jpg', '2023-09-27', 134),
(677179, 'Creed III', 'Creed III', 'Poté, co Adonis Creed ovládl svět boxu, se mu daří jak v kariéře, tak v rodinném životě. Když se po dlouhém trestu ve vězení znovu objeví jeho přítel z dětství a bývalý boxerský zázrak Damian, touží dokázat, že si zaslouží svou šanci v ringu. Konfrontace mezi bývalými přáteli je víc než pouhý zápas. Aby Adonis vyrovnal skóre, musí dát v sázku svou budoucnost a utkat se s Damianem - bojovníkem, který nemá co ztratit.', '/cvsXj3I9Q2iyyIo95AecSd1tad7.jpg', '2023-03-01', 116),
(700391, '65', '65', 'Po nouzovém přistání na neznámé planetě pilot Mills rychle zjistí, že se nachází na Zemi... před 65 miliony let. Jelikož Mills a další přeživší, Koa mají na záchranu jediný pokus, musí se při svém epickém boji o přežití vydat napříč neznámou krajinou plnou nebezpečných prehistorických tvorů.', '/rzRb63TldOKdKydCvWJM8B6EkPM.jpg', '2023-03-02', 93),
(713704, 'Smrtelné zlo: Probuzení', 'Evil Dead Rise', 'Zvrácený příběh dvou odcizených sester, jejichž shledání přeruší probuzení démonů posedlých masem, což je vrhne do totálního boje o přežití, v němž čelí té nejhorší verzi rodiny, jakou si lze představit.', '/hrm4n0WTa0jWQUJjJyfehEwTosu.jpg', '2023-04-12', 96),
(736790, 'Chupa', 'Chupa', 'Osamělý kluk se na návštěvě u příbuzných v Mexiku skamarádí s mytickou bytostí, která se skrývá na dědově ranči, a zažije přitom úžasné dobrodružství.', '/ra3xm8KFAkwK0CdbPRkfYADJYTB.jpg', '2023-04-07', 95),
(758323, 'Papežův vymítač', 'The Pope\'s Exorcist', 'Hlavní vatikánský exorcista Amorth se snaží vyšetřit děsivou posedlost mladého chlapce. Nakonec však odhalí po staletí staré spiknutí, které se Vatikán zoufale snažil utajit.', '/zRcghqFrWwQl9h5FDQW4y0gNVxp.jpg', '2023-04-05', 104),
(872585, 'Oppenheimer', 'Oppenheimer', 'V době, kdy Druhá světová válka ještě vypadala nerozhodně, probíhal na dálku dramatický souboj mezi Spojenými státy a Německem o to, komu se dřív podaří zkonstruovat atomovou bombu a získat nad nepřítelem rozhodující převahu. V Americe se tajný výzkum skrýval pod označením Projekt Manhattan a jedním z jeho klíčových aktérů byl astrofyzik Robert Oppenheimer. Pod obrovským časovým tlakem se s týmem dalších vědců pokoušel sestrojit vynález, který má potenciál zničit celý svět, ale bez jehož včasného dokončení se tentýž svět nepodaří zachránit…', '/uwOo42nxRKeD5pyG2aREp0Dfu2a.jpg', '2023-07-19', 180),
(926393, 'Equalizer 3: Poslední kapitola', 'The Equalizer 3', 'Od chvíle, kdy se Robert McCall vzdal života v elitní jednotce, snaží se vyrovnat s hrůznými činy, které v minulosti spáchal, a nachází zvláštní útěchu ve službě spravedlnosti ve jménu utlačovaných. Když překvapivě zdomácní v jižní Itálii, zjistí, že jeho noví přátelé jsou pod dohledem místních zločineckých bossů. Když se události změní ve smrtící spád, McCall ví, co musí udělat: stát se ochráncem svých přátel a postavit se mafii.', '/9vvzKevgHjkjBfmm7wARpALAB0t.jpg', '2023-08-30', 109),
(980078, 'Medvídek Pú: Krev a med', 'Winnie the Pooh: Blood and Honey', 'Během svého dětství se Kryštůfek Robin skamarádil s Medvídkem Pů, Prasátkem a jejich přáteli, hrál s nimi hry a také jim obstarával jídlo. Jak ale rostl, jeho návštěvy, a s nimi spojené dodávky jídla, byly postupně stále méně časté, kvůli čemuž začali být Pú a ostatní stále více hladoví a zoufalí. Když Kryštůfek odešel na univerzitu, návštěvy přestaly úplně, což vyústilo v to, že Pú a Prasátko zdivočeli a utrhli se z řetězu, a poté zabili a snědli své kamarády. Nyní se po dlouhé době Kryštůfek Robin vrací do lesa, spolu se svou manželkou, aby jí představil své kamarády z dětství. Ti se však cítí zrazeni a po znepřátelení skupiny vysokoškolaček z blízké chaty se vydávají na cestu krvavého masakru.', '/x0pNA86LeWhwP406AKy3oiMZbHf.jpg', '2023-01-27', 84),
(1033219, 'Attack on Titan', 'Attack on Titan', '', '/ay8SLFTMKzQ0i5ewOaGHz2bVuZL.jpg', '2022-09-30', 93),
(1075794, 'Leo', 'Leo', 'Hudební komedie o dospívání a posledním roce na základce z pohledu ještěrky Lea, který žije ve třídě v teráriu. Hlavní postavu namluvil Adam Sandler.', '/pD6sL4vntUOXHmuvJPPZAgvyfd9.jpg', '2023-11-17', 102);

-- --------------------------------------------------------

--
-- Struktura tabulky `movie_comments`
--

CREATE TABLE `movie_comments` (
  `comment_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `movie_comments`
--

INSERT INTO `movie_comments` (`comment_id`, `movie_id`, `user_id`, `comment`, `timestamp`) VALUES
(9, 872585, 1, 'fgvsdfgsdfg', '2023-12-06 02:05:58'),
(12, 753342, 1, 'Docela nuda.', '2023-12-06 02:09:36'),
(17, 507089, 1, 'asdf', '2023-12-06 02:12:06');

-- --------------------------------------------------------

--
-- Struktura tabulky `movie_ratings`
--

CREATE TABLE `movie_ratings` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `movie_ratings`
--

INSERT INTO `movie_ratings` (`user_id`, `movie_id`, `rating`, `timestamp`) VALUES
(1, 1, 5, '2023-04-19 18:10:12'),
(1, 767, 93, '2023-06-13 03:42:45'),
(1, 76600, 60, '2023-04-25 02:11:14'),
(1, 106646, 100, '2023-05-22 03:34:41'),
(1, 385687, 20, '2023-05-22 03:26:39'),
(1, 603692, 50, '2023-04-20 01:02:48'),
(1, 700391, 20, '2023-04-19 18:31:17'),
(1, 736790, 50, '2023-04-19 19:04:22'),
(2, 767, 95, '2023-04-27 06:36:47'),
(2, 76600, 20, '2023-04-20 01:04:47'),
(2, 502356, 50, '2023-04-20 01:04:39'),
(3, 767, 78, '2023-04-27 06:36:12'),
(3, 36993, 10, '2023-04-19 22:14:01'),
(3, 76600, 50, '2023-04-19 22:14:12'),
(13, 76600, 95, '2023-05-22 03:08:00'),
(15, 27205, 100, '2023-11-09 20:30:52'),
(20, 872585, 98, '2023-11-15 23:01:53'),
(22, 76600, 20, '2023-11-30 13:31:10'),
(23, 872585, 85, '2023-12-02 16:40:50');

-- --------------------------------------------------------

--
-- Struktura tabulky `movie_recommendations`
--

CREATE TABLE `movie_recommendations` (
  `source_user_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `movie_recommendations`
--

INSERT INTO `movie_recommendations` (`source_user_id`, `target_user_id`, `movie_id`, `timestamp`, `description`) VALUES
(1, 2, 677179, '2023-04-20 19:22:11', 'Fakt super\r\n'),
(1, 3, 677179, '2023-04-20 18:55:52', 'Je to fakt supr film!'),
(1, 5, 181808, '2023-08-10 21:53:09', 'Hdhsh'),
(1, 20, 872585, '2023-12-06 02:00:33', ''),
(3, 1, 638974, '2023-04-20 19:22:19', 'fakt supr'),
(3, 1, 640146, '2023-04-20 19:30:58', 'konec byl fakt nečekanej! :-O'),
(3, 2, 640146, '2023-04-20 19:30:35', 'Kone byl fakt nečekanej! :O'),
(15, 1, 64690, '2023-11-09 20:36:58', 'Je to tak strašně super film, protože v něm hraju'),
(16, 1, 33380, '2023-11-10 19:22:34', 'xdddddddddddddddddddxdd345678dddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxdddddddddddddddddddxddd'),
(20, 1, 385687, '2023-11-15 23:05:56', 'xd so bad\r\n'),
(22, 1, 76600, '2023-11-30 13:38:00', 'xdd'),
(23, 1, 872585, '2023-12-02 16:44:27', 'bomba');

-- --------------------------------------------------------

--
-- Struktura tabulky `seen_episodes`
--

CREATE TABLE `seen_episodes` (
  `id` bigint(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `seen_episodes`
--

INSERT INTO `seen_episodes` (`id`, `timestamp`, `user_id`) VALUES
(64647, '2023-11-10 19:18:43', 16),
(64741, '2023-11-10 19:18:35', 16),
(64742, '2023-11-10 19:18:42', 16),
(64743, '2023-11-10 19:18:36', 16),
(64766, '2023-11-11 22:25:33', 1),
(286559, '2023-05-22 04:04:44', 8),
(286570, '2023-05-22 04:04:43', 8),
(286575, '2023-05-22 04:04:45', 8),
(286576, '2023-05-22 04:04:42', 8),
(570304, '2023-05-22 20:53:23', 14),
(570305, '2023-05-22 20:53:20', 14),
(570306, '2023-05-22 20:53:21', 14),
(574647, '2023-04-11 00:34:46', 1),
(574648, '2023-04-11 00:34:45', 1),
(574649, '2023-04-11 00:34:46', 1),
(904465, '2023-04-11 00:38:17', 1),
(904466, '2023-04-11 00:38:17', 1),
(904467, '2023-04-11 00:38:17', 1),
(941474, '2023-11-11 22:25:51', 1),
(968597, '2023-11-11 22:28:15', 1),
(1337906, '2023-04-03 22:35:55', 1),
(1338260, '2023-11-15 21:29:44', 1),
(1379139, '2023-04-03 22:35:56', 1),
(1379140, '2023-04-03 22:35:56', 1),
(1379142, '2023-06-13 06:42:08', 1),
(1394478, '2023-11-15 21:29:44', 1),
(1582216, '2023-04-03 22:37:52', 1),
(1586260, '2023-06-11 04:57:24', 1),
(1586260, '2023-04-17 13:41:34', 3),
(1586260, '2023-05-22 00:00:32', 13),
(1725651, '2023-12-02 16:41:29', 23),
(1771432, '2023-11-30 13:34:09', 22),
(1822000, '2023-11-30 13:34:10', 22),
(1822001, '2023-11-30 13:34:11', 22),
(1822002, '2023-11-30 13:34:12', 22),
(1857024, '2023-04-16 01:16:57', 1),
(1857024, '2023-04-17 13:41:34', 3),
(1857024, '2023-05-22 03:07:43', 13),
(1953812, '2023-04-02 17:07:54', 1),
(1980403, '2023-04-17 13:41:38', 3),
(1980403, '2023-05-22 03:07:44', 13),
(1980404, '2023-04-16 01:16:58', 1),
(1980404, '2023-05-22 03:07:45', 13),
(2023593, '2023-04-16 01:17:00', 1),
(2181581, '2023-04-27 06:32:28', 1),
(2228037, '2023-04-13 21:43:27', 3),
(2228477, '2023-12-02 16:41:30', 23),
(2228479, '2023-12-02 16:41:31', 23),
(2228480, '2023-12-02 16:41:32', 23),
(2228481, '2023-12-02 16:41:33', 23),
(2257675, '2023-04-13 21:43:27', 3),
(2261049, '2023-04-13 21:43:28', 3),
(2276928, '2023-12-02 16:41:33', 23),
(2278452, '2023-04-13 21:43:28', 3),
(2278455, '2023-04-13 21:43:29', 3),
(2403865, '2023-08-05 14:26:41', 1),
(2464374, '2023-09-06 13:49:27', 1),
(2464375, '2023-06-12 08:40:16', 1),
(2464378, '2023-06-11 04:57:31', 1),
(2464380, '2023-06-11 04:57:29', 1),
(2464381, '2023-06-11 04:57:28', 1),
(2552685, '2023-08-24 09:26:36', 1),
(2670881, '2023-04-17 22:53:25', 1),
(2670881, '2023-04-17 13:41:19', 3),
(3003763, '2023-05-22 20:49:41', 14),
(3003765, '2023-05-22 20:49:42', 14),
(3003766, '2023-05-22 20:49:42', 14),
(3003769, '2023-05-22 20:49:45', 14),
(3003771, '2023-05-22 20:49:47', 14),
(3241290, '2023-04-02 17:07:55', 1),
(3241291, '2023-05-29 10:10:17', 1),
(3246865, '2023-05-29 10:10:18', 1),
(3246866, '2023-06-09 12:53:50', 1),
(3273258, '2023-04-17 22:53:26', 1),
(3273258, '2023-04-17 13:41:19', 3),
(3273260, '2023-04-17 22:53:26', 1),
(3273260, '2023-04-17 13:41:20', 3),
(3301367, '2023-04-17 22:53:27', 1),
(3301367, '2023-04-17 13:41:21', 3),
(3301368, '2023-04-17 22:53:27', 1),
(3301368, '2023-04-17 13:41:21', 3),
(3301369, '2023-04-17 22:53:28', 1),
(3301369, '2023-04-17 13:41:22', 3),
(3533647, '2023-04-17 22:54:01', 3),
(3533648, '2023-04-17 22:54:02', 3),
(3533649, '2023-04-17 22:54:01', 3),
(3533650, '2023-04-17 22:54:00', 3),
(3533651, '2023-04-17 22:54:00', 3),
(3533653, '2023-04-17 22:53:59', 3),
(3533654, '2023-04-17 22:53:59', 3),
(3533655, '2023-04-17 22:53:58', 3),
(3533656, '2023-04-17 22:53:58', 3),
(3533657, '2023-04-17 22:53:57', 3),
(3533658, '2023-04-17 22:53:57', 3),
(3533659, '2023-04-17 22:53:56', 3),
(3725690, '2023-11-15 23:02:30', 20),
(3733838, '2023-11-15 23:02:30', 20),
(3733839, '2023-11-15 23:02:33', 20),
(3733840, '2023-11-15 23:02:31', 20),
(3733841, '2023-11-15 23:02:32', 20),
(3733842, '2023-11-15 23:02:35', 20),
(3918149, '2023-04-19 00:38:43', 3),
(4071039, '2023-04-27 06:32:29', 1),
(4192805, '2023-11-20 20:16:14', 21),
(4237593, '2023-06-11 04:57:44', 1),
(4237594, '2023-06-11 04:57:45', 1),
(4237596, '2023-06-11 04:57:46', 1),
(4237597, '2023-04-16 02:00:12', 1),
(4237598, '2023-06-09 19:02:38', 1),
(4447686, '2023-11-09 20:32:09', 15),
(4447779, '2023-11-09 20:32:10', 15),
(4502580, '2023-09-28 22:55:42', 1),
(4502583, '2023-09-28 22:55:43', 1),
(4502586, '2023-09-28 22:55:45', 1),
(4743489, '2023-11-20 20:16:14', 21);

-- --------------------------------------------------------

--
-- Struktura tabulky `seen_movies`
--

CREATE TABLE `seen_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabulka viděných filmů.';

--
-- Vypisuji data pro tabulku `seen_movies`
--

INSERT INTO `seen_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 672, '2023-04-10 18:02:30'),
(1, 1771, '2023-04-10 18:01:31'),
(1, 1893, '2023-04-11 02:22:12'),
(1, 10681, '2023-11-20 20:07:44'),
(1, 19995, '2023-04-10 18:01:50'),
(1, 24428, '2023-04-10 18:01:35'),
(1, 27205, '2023-11-09 21:34:39'),
(1, 36993, '2023-04-18 01:14:19'),
(1, 36994, '2023-04-18 01:14:45'),
(1, 75023, '2023-04-11 02:30:02'),
(1, 76600, '2023-04-25 03:36:02'),
(1, 106646, '2023-05-22 05:35:44'),
(1, 181808, '2023-04-11 02:28:03'),
(1, 385687, '2023-06-13 08:41:43'),
(1, 447365, '2023-05-11 23:09:34'),
(1, 593643, '2023-04-10 17:42:48'),
(1, 594767, '2023-04-20 01:31:34'),
(1, 640146, '2023-04-10 18:02:09'),
(1, 872585, '2023-12-06 01:48:19'),
(1, 980078, '2023-04-10 18:02:13'),
(3, 496, '2023-06-13 05:45:58'),
(3, 76600, '2023-04-13 23:38:39'),
(3, 502356, '2023-04-17 15:43:04'),
(3, 603692, '2023-04-13 23:38:45'),
(3, 700391, '2023-04-17 15:43:07'),
(3, 758323, '2023-04-17 15:43:09'),
(13, 76600, '2023-05-22 05:07:52'),
(15, 27205, '2023-11-09 21:30:21'),
(16, 75023, '2023-11-10 20:20:48'),
(16, 76600, '2023-11-10 20:15:58'),
(20, 872585, '2023-11-16 00:01:12'),
(21, 671, '2023-11-20 21:22:40'),
(21, 674, '2023-11-20 21:22:49'),
(21, 12444, '2023-11-20 21:22:57'),
(21, 926393, '2023-11-20 21:16:26'),
(22, 76600, '2023-11-30 14:30:26'),
(23, 872585, '2023-12-02 17:40:37');

-- --------------------------------------------------------

--
-- Struktura tabulky `show_ratings`
--

CREATE TABLE `show_ratings` (
  `user_id` int(11) NOT NULL,
  `show_id` bigint(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `show_ratings`
--

INSERT INTO `show_ratings` (`user_id`, `show_id`, `rating`, `timestamp`) VALUES
(1, 82856, 90, '2023-06-09 19:02:24'),
(1, 88329, 90, '2023-05-22 17:58:59'),
(1, 215803, 50, '2023-04-20 15:44:13'),
(2, 196080, 60, '2023-04-20 13:20:23'),
(3, 196080, 13, '2023-04-19 22:06:00'),
(8, 4194, 100, '2023-05-22 04:05:05'),
(14, 221949, 100, '2023-05-22 20:51:53');

-- --------------------------------------------------------

--
-- Struktura tabulky `show_recommendations`
--

CREATE TABLE `show_recommendations` (
  `source_user_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `show_recommendations`
--

INSERT INTO `show_recommendations` (`source_user_id`, `target_user_id`, `show_id`, `timestamp`, `description`) VALUES
(3, 1, 95396, '2023-05-22 04:14:32', 'Nejlepší seriál od Apple TV');

-- --------------------------------------------------------

--
-- Struktura tabulky `tv_shows`
--

CREATE TABLE `tv_shows` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `poster_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `tv_shows`
--

INSERT INTO `tv_shows` (`id`, `name`, `original_name`, `poster_path`) VALUES
(456, 'Simpsonovi', 'The Simpsons', '/poTtFCp1LjEl187NuqD6ekFplb6.jpg'),
(1418, 'Teorie velkého třesku', 'The Big Bang Theory', '/8xAMaEMWDvEGIfRVSwmGwKBpyu3.jpg'),
(4194, 'Star Wars: Klonové války', 'Star Wars: The Clone Wars', '/e1nWfnnCVqxS2LeTO3dwGyAsG2V.jpg'),
(19077, 'Sága rodu Forsytů', 'The Forsyte Saga', '/rvcdVpJjUMb086r6y9eR9YxTQVJ.jpg'),
(19384, 'Comeback', 'Comeback', '/jBhF1ZoMDb4EPYgFmgRQY7CY9yP.jpg'),
(36361, 'Ulice', 'Ulice', '/3ayWL13P1HeRnyVL9lU9flOdZjq.jpg'),
(45783, 'Kuroko\'s Basketball', '黒子のバスケ', '/ftT1qtT6yWO5rfs237a466N8QRr.jpg'),
(52698, 'الكبير أوي', 'الكبير أوي', '/yOyoBsVGGmSAsvvgJ1NAi7GHR1j.jpg'),
(57243, 'Pán času', 'Doctor Who', '/sz4zF5z9zyFh8Z6g5IQPNq91cI7.jpg'),
(60554, 'Star Wars: Povstalci', 'Star Wars Rebels', '/jmgR8330sKEJehr27rQ3bODnrlP.jpg'),
(67744, 'MINDHUNTER: Lovci myšlenek', 'Mindhunter', '/1vPLUwRI1iN17LhKRQNeBFwZ9Jy.jpg'),
(72879, 'Demain nous appartient', 'Demain nous appartient', '/3uU5uJzOX7xe7mn7YKpBM9oiEZO.jpg'),
(79680, 'Ledová archa', 'Snowpiercer', '/3s6ZyZKurx6wDJZMXSsbUsgjWCI.jpg'),
(82856, 'Mandalorian', 'The Mandalorian', '/6upwFpQr6XqQenoWZ9rFnjCUpTv.jpg'),
(84958, 'Loki', 'Loki', '/voHUmluYmKyleFkTu3lOXQG702u.jpg'),
(85328, 'MOST!', 'MOST!', '/iQZX4bdLEpXIBJYmSxE1IKJWthj.jpg'),
(88329, 'Hawkeye', 'Hawkeye', '/uQdAET8dl403BIVktl5gjtzXRDT.jpg'),
(88808, '通常攻撃が全体攻撃で二回攻撃のお母さんは好きですか？', '通常攻撃が全体攻撃で二回攻撃のお母さんは好きですか？', '/9f4PMYrswGpil2NGS8K8qDqjs6n.jpg'),
(94605, 'Arcane', 'Arcane', '/fqldf2t8ztc9aiwn3k6mlX3tvRT.jpg'),
(95396, 'Odloučení', 'Severance', '/dpXk2VQHP6a4nt4riCNS4Gyc5Vp.jpg'),
(97645, 'Solar Opposites', 'Solar Opposites', '/dPClRec0BXzWG7B9jsTdimoeJpM.jpg'),
(100088, 'The Last of Us', 'The Last of Us', '/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg'),
(101463, 'Al rojo vivo', 'Al rojo vivo', '/ag6PmoBxkF2s1uY3An618NCEt3g.jpg'),
(101604, 'قلبي اطمأن', 'قلبي اطمأن', '/3iNT3rKs8q7qDr1fWxfznimZ7JV.jpg'),
(101978, 'Disney Galerie - Star Wars: Mandalorian', 'Disney Gallery / Star Wars: The Mandalorian', '/6Hc2eHp59iTyMqkhcumNovq2l6y.jpg'),
(103768, 'Sweet Tooth: Chlapec s parožím', 'Sweet Tooth', '/3CrifzkR2kWlD84n34Omv7m4y6I.jpg'),
(114461, 'Ahsoka', 'Ahsoka', '/gYpuQ8UzqaSt1Rm2GXjDLI0BDR1.jpg'),
(130542, 'Bhagya Lakshmi', 'Bhagya Lakshmi', '/eVaGfVPA85AUrCAQoOLb0kY2SZA.jpg'),
(196080, 'منهو ولدنا؟', 'منهو ولدنا؟', '/nEtzUtqVri3v5vyOYdajc4nA9m6.jpg'),
(203057, 'Melur Untuk Firdaus', 'Melur Untuk Firdaus', '/rVxQxsY3bQWTabHUi2Qr3aoOafk.jpg'),
(204370, 'Travessia', 'Travessia', '/jFZJEoPzt2RKSsZG8QEWptX5Xyw.jpg'),
(209085, 'Amor Perfeito', 'Amor Perfeito', '/aOPhyvHDauWFuc3rthpHArCNyrm.jpg'),
(209117, 'Vai na Fé', 'Vai na Fé', '/6QNohzb7YUJ6eWZkXAYU8KGIq.jpg'),
(213713, 'Faltu', 'Faltu', '/lgyFuoXs7GvKJN0mNm7z7OMOFuZ.jpg'),
(215103, 'तेरी मेरी डोरियाँ', 'तेरी मेरी डोरियाँ', '/4BHDmYiuSnNL3nqKIOzLJKYX4AN.jpg'),
(215315, 'रब्ब से है दुआ', 'रब्ब से है दुआ', '/6ikbefd7VeopbBuGgioYMNU5bQj.jpg'),
(215803, 'Batang Quiapo', 'Batang Quiapo', '/9McqS8mgMf5NJCAKZIY6J1oOl8y.jpg'),
(219109, 'Elas por Elas', 'Elas por Elas', '/m0cvvnhnRXdQhLARx7qt9lz7hTE.jpg'),
(221949, 'चाशनी', 'चाशनी', '/vsyxauBA27kB3uCM4pNJaYVSx1S.jpg'),
(239770, 'Pán času', 'Doctor Who', '/2I8aMfUvgRKQvEpBIQVKMbXgMsi.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `tv_show_comments`
--

CREATE TABLE `tv_show_comments` (
  `comment_id` int(11) NOT NULL,
  `tv_show_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `tv_show_comments`
--

INSERT INTO `tv_show_comments` (`comment_id`, `tv_show_id`, `user_id`, `comment`, `timestamp`) VALUES
(2, 82856, 12, 'asdfasdfasdfasfd', '2023-12-06 02:27:56'),
(5, 82856, 1, 'asdfasdfasdfasdf', '2023-12-06 02:32:20');

-- --------------------------------------------------------

--
-- Struktura tabulky `tv_show_episodes`
--

CREATE TABLE `tv_show_episodes` (
  `id` bigint(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `season_number` smallint(6) NOT NULL,
  `episode_number` smallint(11) NOT NULL,
  `air_date` date NOT NULL,
  `runtime` smallint(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `tv_show_episodes`
--

INSERT INTO `tv_show_episodes` (`id`, `show_id`, `season_number`, `episode_number`, `air_date`, `runtime`, `name`) VALUES
(35007, 615, 1, 2, '1999-04-04', 23, ''),
(35008, 615, 1, 3, '1999-04-06', 23, ''),
(35013, 615, 1, 8, '1999-05-11', 23, ''),
(35014, 615, 1, 9, '1999-05-18', 23, ''),
(64647, 1418, 6, 3, '2012-10-11', 22, 'Poznatek o Higgsově bosonu'),
(64741, 1418, 6, 1, '2012-09-27', 22, 'Variabilita večera ve dvou'),
(64742, 1418, 6, 2, '2012-10-04', 22, 'Potenciální možnost rozchodu'),
(64743, 1418, 6, 4, '2012-10-18', 22, 'Minimalizace dopadu návratu'),
(64766, 1418, 1, 1, '2007-09-24', 22, 'Pilot'),
(286559, 4194, 1, 3, '2008-10-10', 22, 'Stín Malevolence'),
(286570, 4194, 1, 2, '2008-10-03', 22, 'Malevolence útočí'),
(286575, 4194, 1, 4, '2008-10-17', 22, 'Zkáza Malevolence'),
(286576, 4194, 1, 1, '2008-10-03', 21, 'Léčka'),
(286589, 4194, 2, 1, '2009-10-02', 22, 'Krádež Holokronu'),
(286590, 4194, 2, 3, '2009-10-09', 22, 'Děti Síly'),
(286609, 4194, 2, 2, '2009-10-02', 22, 'Zásilka zkázy'),
(570304, 19077, 1, 2, '2002-04-14', 75, '2. epizoda'),
(570305, 19077, 1, 3, '2002-04-21', 75, '3. epizoda'),
(570306, 19077, 1, 4, '2002-04-28', 75, '4. epizoda'),
(574647, 19384, 2, 14, '2011-09-05', 30, 'Zabijačka'),
(574648, 19384, 2, 16, '2011-09-19', 30, 'Holter'),
(574649, 19384, 2, 15, '2011-09-12', 30, 'Sulc'),
(904465, 45783, 1, 1, '2012-04-08', 24, '1. epizoda'),
(904466, 45783, 1, 2, '2012-04-15', 24, '2. epizoda'),
(904467, 45783, 1, 3, '2012-04-22', 24, '3. epizoda'),
(941474, 57243, 1, 1, '2005-03-26', 47, 'Rose'),
(968597, 57243, 1, 8, '2005-05-14', 43, 'Den otců'),
(1010972, 60554, 1, 3, '2014-10-27', 22, 'Tajemství starých mistrů'),
(1053814, 60554, 1, 2, '2014-10-20', 22, 'Ukradená stíhačka'),
(1053815, 60554, 1, 1, '2014-10-13', 22, 'Droidi v nesnázích'),
(1337906, 67744, 1, 1, '2017-10-13', 60, '1. epizoda'),
(1338260, 72879, 1, 1, '2017-07-17', 25, '1. epizoda'),
(1379139, 67744, 1, 2, '2017-10-13', 56, '2. epizoda'),
(1379140, 67744, 1, 3, '2017-10-13', 45, '3. epizoda'),
(1379142, 67744, 1, 4, '2017-10-13', 54, '4. epizoda'),
(1394478, 72879, 1, 2, '2017-07-18', 25, '2. epizoda'),
(1582216, 456, 30, 1, '2018-09-30', 22, 'Návrat z ráje'),
(1586260, 82856, 1, 1, '2019-11-12', 41, 'Kapitola 1: Mandalorian'),
(1655477, 85328, 1, 1, '2019-01-07', 45, '1. epizoda'),
(1672201, 85328, 1, 2, '2019-01-14', 45, '2. epizoda'),
(1679186, 85328, 1, 3, '2019-01-21', 45, '3. epizoda'),
(1686699, 85328, 1, 4, '2019-01-28', 45, '4. epizoda'),
(1696703, 85328, 1, 5, '2019-02-04', 45, '5. epizoda'),
(1697643, 85328, 1, 6, '2019-02-11', 45, '6. epizoda'),
(1704562, 85328, 1, 7, '2019-02-18', 45, '7. epizoda'),
(1704563, 85328, 1, 8, '2019-02-25', 45, '8. epizoda'),
(1725651, 79680, 1, 1, '2020-05-17', 52, 'Nejdřív se změnilo počasí'),
(1771432, 88808, 1, 1, '2019-07-13', 24, '1. epizoda'),
(1822000, 88808, 1, 2, '2019-07-20', 24, '2. epizoda'),
(1822001, 88808, 1, 3, '2019-07-27', 24, '3. epizoda'),
(1822002, 88808, 1, 4, '2019-08-03', 24, '4. epizoda'),
(1857024, 82856, 1, 2, '2019-11-15', 34, 'Kapitola 2: Dítě'),
(1953812, 94605, 1, 1, '2021-11-06', 43, 'Tak vás tu vítáme'),
(1980403, 82856, 1, 3, '2019-11-22', 39, 'Kapitola 3: Hřích'),
(1980404, 82856, 1, 4, '2019-11-29', 43, 'Kapitola 4: Útočiště'),
(1987335, 82856, 1, 5, '2019-12-06', 37, 'Kapitola 5: Pistolník'),
(1987336, 82856, 1, 6, '2019-12-13', 45, 'Kapitola 6: Vězeň'),
(1987337, 82856, 1, 7, '2019-12-18', 42, 'Kapitola 7: Zúčtování'),
(2023593, 82856, 1, 8, '2019-12-27', 50, 'Kapitola 8: Vykoupení'),
(2181581, 100088, 1, 1, '2023-01-15', 81, 'Když se ztratíš v temnotě'),
(2211892, 101463, 1, 1, '2011-01-10', 200, '1. epizoda'),
(2215166, 101604, 1, 1, '2018-05-17', 30, '1. epizoda'),
(2223971, 101604, 1, 2, '2018-05-19', 30, '2. epizoda'),
(2228037, 101978, 1, 1, '2020-05-04', 32, 'Režie'),
(2228477, 79680, 1, 2, '2020-05-24', 46, 'Připraveni na nejhorší'),
(2228479, 79680, 1, 3, '2020-05-31', 46, 'Přístup je moc'),
(2228480, 79680, 1, 4, '2020-06-07', 46, 'I bez svého tvůrce'),
(2228481, 79680, 1, 5, '2020-06-14', 47, 'Spravedlnost nikdy nenastoupila'),
(2257675, 101978, 1, 2, '2020-05-08', 28, 'Odkaz'),
(2261049, 101978, 1, 3, '2020-05-15', 25, 'Obsazení'),
(2276928, 79680, 1, 6, '2020-06-21', 46, 'Trable chodí vždycky nevhod'),
(2278452, 101978, 1, 4, '2020-05-22', 27, 'Technologie'),
(2278455, 101978, 1, 5, '2020-05-29', 31, 'Praktická stránka'),
(2403865, 82856, 2, 1, '2020-10-30', 56, 'Kapitola 9: Šerif'),
(2464374, 82856, 2, 2, '2020-11-06', 43, 'Kapitola 10: Pasažérka'),
(2464375, 82856, 2, 3, '2020-11-13', 37, 'Kapitola 11: Dědička'),
(2464377, 82856, 2, 4, '2020-11-20', 41, 'Kapitola 12: Infiltrace'),
(2464378, 82856, 2, 5, '2020-11-27', 48, 'Kapitola 13: Jedi'),
(2464379, 82856, 2, 6, '2020-12-04', 35, 'Kapitola 14: Tragédie'),
(2464380, 82856, 2, 7, '2020-12-11', 40, 'Kapitola 15: Přesvědčení'),
(2464381, 82856, 2, 8, '2020-12-18', 48, 'Kapitola 16: Záchrana'),
(2534997, 84958, 1, 1, '2021-06-09', 53, 'Velké poslání'),
(2552685, 114461, 1, 1, '2023-08-22', 57, 'Část 1: Mistři a učedníci'),
(2670881, 88329, 1, 1, '2021-11-24', 51, 'Hrdinům se vyhýbej'),
(3003763, 103768, 1, 4, '2021-06-04', 43, 'Tajná směska'),
(3003765, 103768, 1, 5, '2021-06-04', 40, 'Tajemství mrazáku'),
(3003766, 103768, 1, 6, '2021-06-04', 43, 'Nebezpečí ve vlaku'),
(3003769, 103768, 1, 7, '2021-06-04', 39, 'Jak Pába potkal Ptáče'),
(3003771, 103768, 1, 8, '2021-06-04', 55, 'Obr'),
(3241290, 94605, 1, 2, '2021-11-06', 40, 'Některá tajemství je lepší nechat být'),
(3241291, 94605, 1, 3, '2021-11-06', 44, 'Změnu přinese jenom násilí'),
(3246865, 94605, 1, 4, '2021-11-13', 40, 'Krásný Den pokroku!'),
(3246866, 94605, 1, 5, '2021-11-13', 40, 'Každý chce být můj nepřítel'),
(3273258, 88329, 1, 2, '2021-11-24', 52, 'Na schovku'),
(3273260, 88329, 1, 3, '2021-12-01', 44, 'Ozvěny'),
(3301367, 88329, 1, 4, '2021-12-08', 42, 'Parťáci, nemám pravdu?'),
(3301368, 88329, 1, 5, '2021-12-15', 46, 'Ronin'),
(3301369, 88329, 1, 6, '2021-12-22', 62, 'Tohle mají být Vánoce?'),
(3533647, 36361, 16, 1, '2020-08-17', 50, '3871. díl'),
(3533648, 36361, 16, 2, '2020-08-18', 50, '3872. díl'),
(3533649, 36361, 16, 3, '2020-08-19', 50, '3873. díl'),
(3533650, 36361, 16, 4, '2020-08-20', 50, '3874. díl'),
(3533651, 36361, 16, 5, '2020-08-21', 50, '3875. díl'),
(3533653, 36361, 16, 6, '2020-08-24', 50, '3876. díl'),
(3533654, 36361, 16, 7, '2020-08-25', 50, '3877. díl'),
(3533655, 36361, 16, 8, '2020-08-26', 50, '3878. díl'),
(3533656, 36361, 16, 9, '2020-08-27', 50, '3879. díl'),
(3533657, 36361, 16, 10, '2020-08-28', 50, '3880. díl'),
(3533658, 36361, 16, 11, '2020-08-31', 50, '3881. díl'),
(3533659, 36361, 16, 12, '2020-09-01', 50, '3882. díl'),
(3725690, 97645, 3, 1, '2022-07-13', 24, '1. epizoda'),
(3733838, 97645, 3, 2, '2022-07-13', 23, '2. epizoda'),
(3733839, 97645, 3, 3, '2022-07-13', 23, '3. epizoda'),
(3733840, 97645, 3, 4, '2022-07-13', 23, '4. epizoda'),
(3733841, 97645, 3, 5, '2022-07-13', 23, '5. epizoda'),
(3733842, 97645, 3, 6, '2022-07-13', 24, '6. epizoda'),
(3749414, 203057, 1, 1, '2022-05-27', 42, '1. epizoda'),
(3749415, 203057, 1, 2, '2022-05-28', 42, '2. epizoda'),
(3749419, 203057, 1, 6, '2022-06-04', 42, '6. epizoda'),
(3749420, 203057, 1, 7, '2022-06-08', 42, '7. epizoda'),
(3918149, 209085, 1, 1, '2023-03-20', 47, '1. epizoda'),
(3936979, 204370, 1, 2, '2022-10-11', 62, '2. epizoda'),
(3936980, 204370, 1, 3, '2022-10-12', 38, '3. epizoda'),
(3936981, 204370, 1, 4, '2022-10-13', 60, '4. epizoda'),
(3936983, 204370, 1, 6, '2022-10-15', 60, '6. epizoda'),
(3936984, 204370, 1, 7, '2022-10-17', 62, '7. epizoda'),
(3936985, 204370, 1, 8, '2022-10-18', 55, '8. epizoda'),
(3936986, 204370, 1, 9, '2022-10-19', 32, '9. epizoda'),
(3936987, 204370, 1, 10, '2022-10-20', 64, '10. epizoda'),
(3936988, 204370, 1, 11, '2022-10-21', 57, '11. epizoda'),
(3936989, 204370, 1, 12, '2022-10-22', 59, '12. epizoda'),
(4024142, 204370, 1, 13, '2022-10-24', 60, '13. epizoda'),
(4071039, 100088, 1, 2, '2023-01-22', 53, 'Nakažení'),
(4071040, 100088, 1, 3, '2023-01-29', 77, 'Long Long Time'),
(4071041, 100088, 1, 4, '2023-02-05', 47, 'Drž mě za ruku'),
(4071042, 100088, 1, 5, '2023-02-12', 60, 'Vydržet a přežít'),
(4071043, 100088, 1, 6, '2023-02-19', 61, 'Rodina'),
(4071045, 100088, 1, 7, '2023-02-26', 57, 'Napospas'),
(4071046, 100088, 1, 8, '2023-03-05', 52, 'V časech nouze'),
(4071047, 100088, 1, 9, '2023-03-12', 46, 'Hledej světlo'),
(4082902, 82856, 3, 1, '2023-03-01', 37, 'Kapitola 17: Odpadlík'),
(4089876, 215803, 1, 1, '2023-02-13', 50, '1. epizoda'),
(4192805, 219109, 1, 1, '2023-09-25', 36, '1. epizoda'),
(4237589, 82856, 3, 2, '2023-03-08', 45, 'Kapitola 18: Doly na Mandaloru'),
(4237591, 82856, 3, 3, '2023-03-15', 58, 'Kapitola 19: Obrácení'),
(4237593, 82856, 3, 4, '2023-03-22', 33, 'Kapitola 20: Nalezenec'),
(4237594, 82856, 3, 5, '2023-03-29', 44, 'Kapitola 21: Pirát'),
(4237596, 82856, 3, 6, '2023-04-05', 44, 'Kapitola 22: Žoldnéři'),
(4237597, 82856, 3, 7, '2023-04-12', 53, 'Kapitola 23: Spiknutí'),
(4237598, 82856, 3, 8, '2023-04-19', 39, 'Kapitola 24: Návrat'),
(4287726, 221949, 1, 1, '2023-03-09', 30, '1. epizoda'),
(4447686, 84958, 2, 1, '2023-10-05', 48, 'Ouroboros'),
(4447779, 84958, 2, 2, '2023-10-12', 52, 'Bídák Brad'),
(4502580, 114461, 1, 2, '2023-08-22', 44, 'Část 2: V potu tváře'),
(4502583, 114461, 1, 3, '2023-08-29', 37, 'Část 3: Čas odletu'),
(4502586, 114461, 1, 4, '2023-09-05', 41, 'Část 4: Ztracení Jediové'),
(4743489, 219109, 1, 2, '2023-09-26', 38, '2. epizoda');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `watch_limit` smallint(6) NOT NULL,
  `public_profile` tinyint(1) NOT NULL,
  `moderator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabulka uživatelů.';

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `watch_limit`, `public_profile`, `moderator`) VALUES
(1, 'vojtechnerad', 'Vojtěch', 'Nerad', 'nerv01@vse.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-05-11 22:43:26', 400, 1, 0),
(2, 'tomdvor', 'Tomáš', 'Dvořák', 'tomasdvorak@email.com', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-27 06:37:33', 180, 0, 0),
(3, 'jannovak', 'Jan', 'Novák', 'j@novak.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 21:44:29', 120, 1, 0),
(4, 'uzivatel123', 'Karel', 'Häusler', 'dalsi.uzivatel@xd.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:21:23', 500, 0, 0),
(5, 'honznov', 'Honza', 'Nový', 'dalsi.uzivatel@xd.czd', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-27 06:40:00', 500, 1, 0),
(6, 'tomasdvorak', 'Tomáš', 'Dvořák', 'tomduben@xd.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:49:47', 500, 0, 0),
(7, 'davidkohout', 'David', 'Kohout', 'd.k@email.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:50:42', 200, 0, 0),
(8, 'algernon', 'Martin', 'Danielčík', 'algernon@email.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:51:05', 555, 1, 0),
(9, 'paveld', 'Pavel', 'Dočkal', 'p.d@email.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:51:51', 231, 0, 0),
(11, 'luksob', 'Lukáš', 'Sobotka', 'l.s@email.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:52:02', 231, 1, 0),
(12, 'suchomelmichal', 'Michal', 'Suchomel', 'm.s@email.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 18:52:14', 231, 0, 0),
(13, 'joebiden', 'Joe', 'Biden', 'joe@biden.xd', '$2y$10$4R6/Ag3Dmyks4F8hjzB3PeMkNHLPOsweyXwa8K62W/nV7dPmRJj/e', '2023-05-21 23:04:19', 120, 0, 0),
(14, 'Alois', 'Ufik', 'Nufik', 'zdenek.smutny@vse.cz', '$2y$10$39JDCsxIqmJ7quC8ITvC4OfOXeVryXUo84wYYNS9tMdhPFhc3VzT6', '2023-05-22 20:49:05', 198, 0, 0),
(15, 'Meme', 'Matyáš', 'Brož', 'matybroz20@gmail.com', '$2y$10$4oK2XjBvpoWBDLn2M8A.6.j/XWlVeV1HIGnXBudv5TrZDRE9cYDcm', '2023-11-09 20:29:38', 600, 0, 0),
(16, '\';`--;🇺🇳', 'Flufik', 'Pufik', 'tohle-neeeee@docasnyemail.sk', '$2y$10$6tpGFTSEbsloxtXwFMxEXud19.DvWB/X0vx6EpmyQnchIjTzN5ZjO', '2023-11-10 19:14:25', 666, 1, 0),
(17, 'xdsadf', 'asd', 'asdf', 'vojtech.nerad2@gmail.co', '$2y$10$WoOR.MJkubHHy7tH8pfGReRjZ13Dk4cYkHF6odjguFHiQhlx/mYTy', '2023-11-13 23:46:49', 123, 0, 0),
(18, 'sadf', 'asdfasdf', 'asdfasdfasdf', 'vojtech.nerad2@gmai.xd', '$2y$10$7fkNNRJd7nLJkDQ325AnjOE0PbvI89wsaDabSLLMkvuQMFXmRN/Wy', '2023-11-13 23:47:10', 33, 1, 0),
(19, 'jobidet', 'Joe', 'Bidet', 'joe@bidet.xd', '$2y$10$3S7jK9gmiSEZGUxfys/aj.TFF3dbGT3Nu/rczRPHbWvO/KqHqLfMK', '2023-11-14 00:08:35', 31, 0, 0),
(20, 'fanatisko', 'Lucius', 'Evorn', 'krap666999@gmail.com', '$2y$10$A3XmKyQy9r6/zx8XdGf0aO7fGfzU7/56bYgr6cwZ.asSRz5tAb3wO', '2023-11-15 23:00:26', 1440, 1, 0),
(21, 'mvst', 'Marek', 'Vašut', 'mvst@xd.xd', '$2y$10$TGhq0TxBuMea0AVOekywI.7S.ABDKkoN3KBLRCV/hWAuX87O0G6VK', '2023-11-20 20:06:51', 500, 1, 0),
(22, 'vojner', 'nicem', 'neuďál', 'muzestamdatcokoliv@gmail.com', '$2y$10$z3uX8JVaIGGacOOYpE6Sx.PO7GlqgAtzu7GOeaGK8BI8I.fRAXyl.', '2023-11-30 13:29:26', 420, 1, 0),
(23, 'MurakixCzech', 'Tomáš', 'Dvořák', 'murakixx@email.cz', '$2y$10$/yxUaM7b5SfRKxp2XAYcn.VGVwDIydR9MfAijC9GPeGoblI/VHv..', '2023-12-02 16:40:22', 1440, 0, 0);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `bookmarked_movies`
--
ALTER TABLE `bookmarked_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexy pro tabulku `bookmarked_tv_shows`
--
ALTER TABLE `bookmarked_tv_shows`
  ADD PRIMARY KEY (`user_id`,`show_id`);

--
-- Indexy pro tabulku `favorite_movies`
--
ALTER TABLE `favorite_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexy pro tabulku `favorite_tv_shows`
--
ALTER TABLE `favorite_tv_shows`
  ADD PRIMARY KEY (`user_id`,`show_id`);

--
-- Indexy pro tabulku `friendslist`
--
ALTER TABLE `friendslist`
  ADD PRIMARY KEY (`requesterId`,`adresseeId`),
  ADD KEY `adresseeId` (`adresseeId`);

--
-- Indexy pro tabulku `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexy pro tabulku `movie_comments`
--
ALTER TABLE `movie_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexy pro tabulku `movie_ratings`
--
ALTER TABLE `movie_ratings`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexy pro tabulku `movie_recommendations`
--
ALTER TABLE `movie_recommendations`
  ADD PRIMARY KEY (`source_user_id`,`target_user_id`,`movie_id`),
  ADD KEY `target_user_id` (`target_user_id`);

--
-- Indexy pro tabulku `seen_episodes`
--
ALTER TABLE `seen_episodes`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexy pro tabulku `show_ratings`
--
ALTER TABLE `show_ratings`
  ADD PRIMARY KEY (`user_id`,`show_id`);

--
-- Indexy pro tabulku `show_recommendations`
--
ALTER TABLE `show_recommendations`
  ADD PRIMARY KEY (`source_user_id`,`target_user_id`,`show_id`),
  ADD KEY `target_user_id` (`target_user_id`);

--
-- Indexy pro tabulku `tv_shows`
--
ALTER TABLE `tv_shows`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `tv_show_comments`
--
ALTER TABLE `tv_show_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexy pro tabulku `tv_show_episodes`
--
ALTER TABLE `tv_show_episodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `movie_comments`
--
ALTER TABLE `movie_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pro tabulku `tv_show_comments`
--
ALTER TABLE `tv_show_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `bookmarked_movies`
--
ALTER TABLE `bookmarked_movies`
  ADD CONSTRAINT `bookmarked_movies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `bookmarked_tv_shows`
--
ALTER TABLE `bookmarked_tv_shows`
  ADD CONSTRAINT `bookmarked_tv_shows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `favorite_movies`
--
ALTER TABLE `favorite_movies`
  ADD CONSTRAINT `favorite_movies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `favorite_tv_shows`
--
ALTER TABLE `favorite_tv_shows`
  ADD CONSTRAINT `favorite_tv_shows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `friendslist`
--
ALTER TABLE `friendslist`
  ADD CONSTRAINT `friendslist_ibfk_1` FOREIGN KEY (`requesterId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friendslist_ibfk_2` FOREIGN KEY (`adresseeId`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `movie_ratings`
--
ALTER TABLE `movie_ratings`
  ADD CONSTRAINT `movie_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `movie_recommendations`
--
ALTER TABLE `movie_recommendations`
  ADD CONSTRAINT `movie_recommendations_ibfk_1` FOREIGN KEY (`source_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `movie_recommendations_ibfk_2` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `seen_episodes`
--
ALTER TABLE `seen_episodes`
  ADD CONSTRAINT `seen_episodes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `show_ratings`
--
ALTER TABLE `show_ratings`
  ADD CONSTRAINT `show_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `show_recommendations`
--
ALTER TABLE `show_recommendations`
  ADD CONSTRAINT `show_recommendations_ibfk_1` FOREIGN KEY (`source_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `show_recommendations_ibfk_2` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
