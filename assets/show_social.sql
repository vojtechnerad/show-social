-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 02:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `show_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarked_movies`
--

CREATE TABLE `bookmarked_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmarked_movies`
--

INSERT INTO `bookmarked_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 76600, '2023-04-18 23:23:48'),
(1, 502356, '2023-04-18 23:23:44'),
(1, 594767, '2023-04-18 23:23:46'),
(1, 603692, '2023-04-18 23:23:52'),
(1, 677179, '2023-04-18 23:23:50'),
(3, 76600, '2023-04-18 23:27:36'),
(3, 677179, '2023-04-18 23:27:34'),
(3, 700391, '2023-04-18 23:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarked_tv_shows`
--

CREATE TABLE `bookmarked_tv_shows` (
  `user_id` int(11) NOT NULL,
  `show_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmarked_tv_shows`
--

INSERT INTO `bookmarked_tv_shows` (`user_id`, `show_id`, `timestamp`) VALUES
(1, 456, '2023-04-18 23:17:10'),
(1, 19384, '2023-04-18 23:16:53'),
(1, 67744, '2023-04-18 23:16:59'),
(1, 82856, '2023-04-18 23:15:06'),
(1, 88329, '2023-04-18 23:16:47'),
(1, 94605, '2023-04-18 23:16:57'),
(3, 82856, '2023-04-18 23:54:03'),
(3, 100088, '2023-04-19 00:09:30'),
(3, 196080, '2023-04-18 23:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_movies`
--

CREATE TABLE `favorite_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorite_movies`
--

INSERT INTO `favorite_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(3, 76600, '2023-04-19 00:08:25'),
(3, 677179, '2023-04-19 00:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_tv_shows`
--

CREATE TABLE `favorite_tv_shows` (
  `user_id` int(11) NOT NULL,
  `show_id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorite_tv_shows`
--

INSERT INTO `favorite_tv_shows` (`user_id`, `show_id`, `timestamp`) VALUES
(3, 82856, '2023-04-18 23:54:04'),
(3, 100088, '2023-04-19 00:09:29'),
(3, 203057, '2023-04-19 00:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `friendslist`
--

CREATE TABLE `friendslist` (
  `requesterId` int(11) NOT NULL,
  `adresseeId` int(11) NOT NULL,
  `isConfirmed` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friendslist`
--

INSERT INTO `friendslist` (`requesterId`, `adresseeId`, `isConfirmed`, `timestamp`) VALUES
(1, 2, 1, '2023-04-13 22:30:32'),
(1, 5, 0, '2023-04-13 18:24:57'),
(1, 6, 0, '2023-04-13 21:37:42'),
(1, 7, 0, '2023-04-13 21:37:22'),
(1, 11, 0, '2023-04-13 21:37:18'),
(3, 1, 1, '2023-04-13 20:36:04'),
(3, 2, 1, '2023-04-05 04:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `original_title` varchar(100) NOT NULL,
  `overview` varchar(1000) NOT NULL,
  `poster_path` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  `runtime` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `original_title`, `overview`, `poster_path`, `release_date`, `runtime`) VALUES
(496, 'Borat: Nakoukání do amerycké kultůry na obědnávku slavnoj kazašskoj národu', 'Borat: Cultural Learnings of America for Make Benefit Glorious Nation of Kazakhstan', 'Borat Sagdijev je šestým nejznámějším Kazachem a nejlepším televizním reportérem Kazašské státní televize, která ho vyšle do USA, aby zde natočil dokument o této „zemi neomezených možností“. A případně si našel novou manželku, protože tu starou tlustou mu znásilnil a roztrhal medvěd.  Cohen s filmovým štábem putuje po Spojených státech a uvádí do rozpaků nic netušící lidi, kteří se domnívají, že jsou svědky natáčení skutečného dokumentu pro kazašskou televizi. Cohen jde ovšem tentokrát v drsnosti a politické nekorektnosti svého humoru mnohem dál, než bylo možné v televizní show. Nebude ušetřen nikdo!', '/kfkyALfD4G1mlBJI1lOt2QCra4i.jpg', '2006-11-01', 84),
(671, 'Harry Potter a Kámen mudrců', 'Harry Potter and the Philosopher\'s Stone', 'Harry Potter se v den svých jedenáctých narozenin dozvídá, že je osiřelým synem dvou velkých kouzelníků a sám má magické schopnosti. Na Škole čar a kouzel v Bradavicích se Harry mimo jiné naučí hrát famfrpál na létajícím koštěti a sehraje vzrušující šachovou partii s živými figurami, aby se mohl postavit Tomu, jehož jméno se nesmí vyslovit, který je odhodlán ho zahubit.', '/2EpqAuG2ES1GCSx6Ggbi9RL5c53.jpg', '2001-11-16', 152),
(672, 'Harry Potter a Tajemná komnata', 'Harry Potter and the Chamber of Secrets', 'Harry Potter se po prázdninách vrací do Bradavic a nastupuje do druhého ročníku. A to i přes varování domácího skřítka Dobbyho, podle kterého mu v čarodějné škole hrozí smrt. Harry nedbá nářků skřítka působícího víc škody než užitku, ale potom se skutečně začnou dít podivné věci, na stěnách se objevují neznámé nápisy a několik studentů je přepadeno tajemným přízrakem. Co s tím má společného Tajemná komnata? Stojí za spiknutím opět Voldemort? Kdo je Zmijozelův dědic? Záhadu se Harry vydává rozluštit společně se svými starými známými – Ronem a Hermionou.', '/676E2pDMxqFOPAV9RWjFrRNa5n0.jpg', '2002-11-13', 161),
(767, 'Harry Potter a Princ dvojí krve', 'Harry Potter and the Half-Blood Prince', 'Povzbuzeni návratem Lorda Voldemorta působí Smrtijedi spoušť jak ve světě mudlů, tak ve světě kouzelníků a Bradavice už dávno nejsou tím bezpečným místem, jakým kdysi bývaly. Harry má podezření, že nebezpečí je přímo v Bradavicích, ale Brumbál se soustředí na přípravu na poslední bitvu, která se rychle blíží. Potřebuje, aby mu Harry pomohl odkrýt důležitý klíč, který vede k rozuzlení Voldemortovy obrany – rozhodující informaci ale zná jen bývalý bradavický profesor Horác Křiklan. Vědom si toho přiměje Brumbál svého starého kolegu, aby se vrátil na své staré místo, a slíbí mu vyšší plat, větší kancelář a navíc možnost učit slavného Harryho Pottera.Mezitím útočí na studenty ještě úplně jiný nepřítel – teenagerovské hormony. Harryho dlouhodobé přátelství s Ginny Weasleyovou přerůstá v hlubší city, ale v cestě stojí její přítel, Dean Thomas, a to nemluvě o jejím velkém bratru Ronovi.', '/2TbTfI93E77GT0gF6AkRAqICTrr.jpg', '2009-07-07', 147),
(1771, 'Captain America: První Avenger', 'Captain America: The First Avenger', 'Steve Rogers je idealistický mladík, který stejně jako drtivá většina jeho vrstevníků touží vstoupit do armády, aby mohl pomoci zdolat nacisty, až se jeho země zapojí do Druhé světové války. Jenže nemá sebemenší šanci, protože je podměrečný a neduživý a jediným jeho předpokladem je zarputilost, s jakou se nechává opakovaně vyhazovat od odvodových komisí. Ta ve finále rozhodne o tom, že ho vyberou jako vhodného kandidáta pro vědecký experiment, který má produkovat Supervojáky. Jeho premiéra se vydaří a ze Stevea se díky vědeckému týmu vedeném Dr. Erskinem stane dokonalá lidská bytost. Na boj s nacisty přesto nedojde, protože se zjeví mnohem nebezpečnější nepřítel. Tajná organizace HYDRA, vedená všehoschopným gaunerem Johannem Schmidtem, totiž začala spřádat vlastní plány na ovládnutí světa. Steve Rogers dostane štít, který se stane jeho poznávacím znamením, skupinku schopných parťáků a vyrazí do mise, která mu může zajistit nesmrtelnost. Nebo přinést smrt.', '/ym0xcdKmMKDJZrQxpDjPJMs5dKV.jpg', '2011-07-22', 125),
(1893, 'Star Wars: Epizoda I - Skrytá hrozba', 'Star Wars: Episode I - The Phantom Menace', 'Galaktickou republikou zmítají nepokoje. Vznikly spory ohledně zdanění obchodních cest k odlehlým hvězdným soustavám. Chamtivá Obchodní federace doufá, že záležitost vyřeší její armáda bojových droidů, která začne úplnou blokádu malé planety Naboo. Zatímco Republikový kongres vede o těchto dramatických událostech zdlouhavé rozhovory, Nejvyšší kancelář tajně vyšle dva rytíře Jedi, ochránce míru a spravedlnosti v galaxii, aby konflikt zažehnali...', '/g0fFRDE3yrgm44dBY1n4PvnNlhh.jpg', '1999-05-19', 136),
(19995, 'Avatar', 'Avatar', 'Příběh se odehrává v budoucnosti na planetě Pandora, kde lidé ze Země objeví vzácnou horninu unobtanium a rozhodnou se ji vytěžit. V cestě jim však stojí místní domorodci Na’vi. Aby pozemšťané získali jejich důvěru, vytvoří umělé tvory „avatary“, kteří vzhledem odpovídají obyvatelům planety, ale je do nich přenášeno lidské vědomí. Hlavní hrdina, ochrnutý mariňák Jake, se tak v zapůjčené podobě dostává k místnímu kmeni Omaticaya. Brzy prohlédne zpupné chování lidí, pozná kouzlo života v symbióze s přírodou a zamiluje se do dcery náčelníka Neytiri. V rozhodujícím boji o budoucnost planety se proto postaví na stranu Na’vi.', '/q6ilgi1VzOMYRhcGEdYNBD3Lm5O.jpg', '2009-12-15', 162),
(24428, 'Avengers', 'The Avengers', 'Marvel Studio uvádí \"Marvelovské mstitele\" - super hrdinský tým všech dob, který přestaví ikonické super hrdiny - Iron Mana, Neuvěřitelného Hulka, Thora, Captaina Americu, Hawkeye a Black Widow. Když se objeví nečekaný nepřítel, který ohrožuje světovou bezpečnost a bezpečí , Nick Fury, ředitel mezinárodní mírové agentury známé také jako S.H.I.E.L.D., zjistí, že potřebuje tým, aby odvrátil světovou katastrofu. Začíná provádět nábor po celém světě.', '/jEQswViXNu2PvUvWzQoxhKjQc3p.jpg', '2012-04-25', 142),
(36993, 'Slunce, seno a pár facek', 'Slunce, seno a pár facek', 'Již podruhé jsme zavítali do jihočeských Hoštic, abychom sledovali osud Konopníků a Škopků. Nahlédneme do vztahu mezi těhotnou Blaženou a Vencou, kolem kterého zhrzená Milada z hospody rozšíří fámy. Vzniká skandál a hotová bitva mezi jejich rodinami. Ve stejném duchu probíhá vztah mezi živočichářem Bédou a účetní JZD Evičkou.', '/n7MSy0Z9R9JaLIZTdLpnAbOZVSA.jpg', '1989-07-01', 127),
(36994, 'Slunce, seno, jahody', 'Slunce, seno, jahody', 'Všechno začíná v okamžiku, kdy se do jihočeské vísky Hoštice přichází student vysoké zemědělské školy Šimon Plánička, aby nastoupil v místním JZD na brigádu a současně se pokusil prověřit v praxi svůj experiment na téma \"dojivost krav v závislosti na kultuře prostředí.\" Vedení JZD však nechce o pochybném experimentu ani slyšet. Všechno se však změní v okamžiku, kdy se po vesnici rozkřikne, že je Šimon synem předsedy krajské zemědělské správy, také se totiž jmenuje Plánička. Blažena, dcera paní Škopkové u níž je Šimon ubytován dostane za úkol vypátrat, jak se věci mají. Všechno však komplikuje žárlivost Blaženina kluka Vency. Film musel být před uvedením do distribuce pro kina zkrácen o deset minut.', '/kKlBTBqRoV7pX2utkWvFSmQqPal.jpg', '1983-09-01', 83),
(67717, 'Hard Bounty', 'Hard Bounty', '', '/yy35crQiGb3RXhzSAv8LJqQUN0x.jpg', '1995-06-01', 88),
(75023, '„Marečku, podejte mi pero!“', '„Marečku, podejte mi pero!“', 'Jiří Kroupa, mistr v továrně na zemědělské stroje, by mohl povýšit - musel by ovšem vystudovat večerní průmyslovku. Pan Kroupa se tomu vehementně brání, nakonec však podlehne naléhání členů dílenského výboru a na školu se dá zapsat. Stejný vzdělávací ústav navštěvuje i jeho syn, přes den dokonce sedává v téže lavici. Náhle se ukazuje, že tatínek má mnohem horší prospěch než jeho ratolest. Dokáže si rodič napravit reputaci a obstát před profesory i spolužáky?', '/eINA2AN1ST3Iti7O8BWK7VSorxt.jpg', '1976-10-08', 93),
(76600, 'Avatar: The Way of Water', 'Avatar: The Way of Water', 'Se po více jak deseti letech znovu setkáváme s Jackem Sully, Neytiri a jejich dětmi, kteří stále bojují za to, aby se udrželi v bezpečí a naživu.', '/yXLr49f3kNFrgUZpLrTA0M2yHTx.jpg', '2022-12-14', 192),
(181808, 'Star Wars: Poslední z Jediů', 'Star Wars: The Last Jedi', 'Superzbraň Hvězda smrti byla zničena, zároveň tím ale byla odhalena poloha základny Odboje vedeného generálkou Leiou na planetě D’Qar. Členové odboje za podpory stíhacích pilotů se chystají na rozsáhlou evakuaci. Nejvyšší vůdce Snoke z Prvního řádu na ně vysílá obrovskou flotilu pod velením generála Huxe a svého učedníka Kyla Rena, který nedávno zabil svého otce Hana Sola. Mezitím mladá Rey odlétá za Lukem Skywalkerem do chrámu Jediů na okraji galaxie a prosí ho o pomoc. Věří, že se mistr vrátí a vnese do boje jiskru naděje. Snoke propojuje mysl svého temného adepta Kyla a Rey. Ti teď telepaticky komunikují napříč galaxií. Jeden druhého se snaží získat na svoji stranu. Kylo odhaluje dívce, co se stalo mezi ním a Lukem a co ho přimělo dát se na stranu temna. Rey je přesvědčena, že se Kylo může vrátit na stranu dobra, a odlétá za ním…', '/zVCnE1hte1sxQUfPCq63tqMYewG.jpg', '2017-12-13', 150),
(300619, 'Ada', 'Ada', '', '/qQODYXWm78usLF6jCZtCKVWZbYw.jpg', '1988-04-18', 64),
(315162, 'Kocour v botách: Poslední přání', 'Puss in Boots: The Last Wish', 'Kocour v botách zjišťuje, že jeho vášeň pro dobrodružství si vybrala svou daň: už přišel o osm ze svých devíti životů. A tak se vydává na výpravu za bájným Posledním přáním, aby svých devět životů zase obnovil.', '/7eTzBZaKUInBtpUe0BuJ9z0WHIL.jpg', '2022-12-07', 103),
(502356, 'Super Mario Bros. ve filmu', 'The Super Mario Bros. Movie', 'Mario a Luigi, legendární Super Mario Bros., se konečně dočkali svého filmu! Nejslavnější a nejkníratější instalatér na světě se vydává za dobrodružstvím do světa plného fantazie a kouzel, který bude muset zachránit  před nenasytným netvorem. Protože kdo jiný by to zvládl?', '/AlvvnaLaaSLNQzHo5bd4VadncPJ.jpg', '2023-04-05', 92),
(593643, 'Menu', 'The Menu', 'Mladý pár cestuje na odlehlý ostrov, aby se najedl v luxusní restauraci, kde šéfkuchař připravil bohaté menu s několika šokujícími překvapeními.', '/zA9X8DpLSctaQvDvXPnm1RY2XZR.jpg', '2022-11-17', 107),
(594767, 'Shazam! Hněv bohů', 'Shazam! Fury of the Gods', 'Billy Batson a jeho nevlastní sourozenci se stále učí skloubit životy teenagerů s kariérou superhrdinů. Když na Zemi ale dorazí trojice prastarých pomstychtivých bohyň, Billy a jeho rodina jsou vrženi do boje nejen o superschopnosti, ale i životy jich samých i celého světa.', '/gi7MmM19OKGvOw8xEnGSFvPCu2k.jpg', '2023-03-15', 130),
(603692, 'John Wick: Kapitola 4', 'John Wick: Chapter 4', 'John Wick odhalí cestu, jak porazit Nejvyšší radu. Než se mu však podaří získat svobodu, musí čelit novému nepříteli, který má mocné spojence po celém světě. Bude to o to težší, že nová spojenectví mění staré přátele v nepřátele...', '/sIQ9Lqw1QVZPq4tVgbPcPoE38GM.jpg', '2023-03-22', 170),
(640146, 'Ant-Man a Wasp: Quantumania', 'Ant-Man and the Wasp: Quantumania', 'Scott Lang a Hope Van Dyne spolu s Hankem Pymem a Janet Van Dyne prozkoumávají Quantum Realm, kde interagují s podivnými tvory a vydávají se na dobrodružství, které přesahuje hranice toho, co považovali za možné.', '/jgyhDWuiqD9HNwteJ7TRaOHK3u.jpg', '2023-02-15', 125),
(677179, 'Creed III', 'Creed III', 'Poté, co Adonis Creed ovládl svět boxu, se mu daří jak v kariéře, tak v rodinném životě. Když se po dlouhém trestu ve vězení znovu objeví jeho přítel z dětství a bývalý boxerský zázrak Damian, touží dokázat, že si zaslouží svou šanci v ringu. Konfrontace mezi bývalými přáteli je víc než pouhý zápas. Aby Adonis vyrovnal skóre, musí dát v sázku svou budoucnost a utkat se s Damianem - bojovníkem, který nemá co ztratit.', '/cvsXj3I9Q2iyyIo95AecSd1tad7.jpg', '2023-03-01', 116),
(700391, '65', '65', 'Po nouzovém přistání na neznámé planetě pilot Mills rychle zjistí, že se nachází na Zemi... před 65 miliony let. Jelikož Mills a další přeživší, Koa mají na záchranu jediný pokus, musí se při svém epickém boji o přežití vydat napříč neznámou krajinou plnou nebezpečných prehistorických tvorů.', '/rzRb63TldOKdKydCvWJM8B6EkPM.jpg', '2023-03-02', 93),
(758323, 'Papežův vymítač', 'The Pope\'s Exorcist', 'Hlavní vatikánský exorcista Amorth se snaží vyšetřit děsivou posedlost mladého chlapce. Nakonec však odhalí po staletí staré spiknutí, které se Vatikán zoufale snažil utajit.', '/zRcghqFrWwQl9h5FDQW4y0gNVxp.jpg', '2023-04-05', 104),
(980078, 'Medvídek Pú: Krev a med', 'Winnie the Pooh: Blood and Honey', 'Během svého dětství se Kryštůfek Robin skamarádil s Medvídkem Pů, Prasátkem a jejich přáteli, hrál s nimi hry a také jim obstarával jídlo. Jak ale rostl, jeho návštěvy, a s nimi spojené dodávky jídla, byly postupně stále méně časté, kvůli čemuž začali být Pú a ostatní stále více hladoví a zoufalí. Když Kryštůfek odešel na univerzitu, návštěvy přestaly úplně, což vyústilo v to, že Pú a Prasátko zdivočeli a utrhli se z řetězu, a poté zabili a snědli své kamarády. Nyní se po dlouhé době Kryštůfek Robin vrací do lesa, spolu se svou manželkou, aby jí představil své kamarády z dětství. Ti se však cítí zrazeni a po znepřátelení skupiny vysokoškolaček z blízké chaty se vydávají na cestu krvavého masakru.', '/x0pNA86LeWhwP406AKy3oiMZbHf.jpg', '2023-01-27', 84),
(1033219, 'Attack on Titan', 'Attack on Titan', '', '/ay8SLFTMKzQ0i5ewOaGHz2bVuZL.jpg', '2022-09-30', 93);

-- --------------------------------------------------------

--
-- Table structure for table `seen_episodes`
--

CREATE TABLE `seen_episodes` (
  `id` bigint(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seen_episodes`
--

INSERT INTO `seen_episodes` (`id`, `timestamp`, `user_id`) VALUES
(574647, '2023-04-11 00:34:46', 1),
(574648, '2023-04-11 00:34:45', 1),
(574649, '2023-04-11 00:34:46', 1),
(904465, '2023-04-11 00:38:17', 1),
(904466, '2023-04-11 00:38:17', 1),
(904467, '2023-04-11 00:38:17', 1),
(1337906, '2023-04-03 22:35:55', 1),
(1379139, '2023-04-03 22:35:56', 1),
(1379140, '2023-04-03 22:35:56', 1),
(1582216, '2023-04-03 22:37:52', 1),
(1586260, '2023-04-16 01:16:57', 1),
(1586260, '2023-04-17 13:41:34', 3),
(1857024, '2023-04-16 01:16:57', 1),
(1857024, '2023-04-17 13:41:34', 3),
(1953812, '2023-04-02 17:07:54', 1),
(1980403, '2023-04-16 01:16:58', 1),
(1980403, '2023-04-17 13:41:38', 3),
(1980404, '2023-04-16 01:16:58', 1),
(1987335, '2023-04-16 01:16:59', 1),
(2023593, '2023-04-16 01:17:00', 1),
(2215166, '2023-04-16 02:00:01', 1),
(2223971, '2023-04-16 02:00:02', 1),
(2228037, '2023-04-13 21:43:27', 3),
(2257675, '2023-04-13 21:43:27', 3),
(2261049, '2023-04-13 21:43:28', 3),
(2278452, '2023-04-13 21:43:28', 3),
(2278455, '2023-04-13 21:43:29', 3),
(2464375, '2023-04-16 01:17:06', 1),
(2670881, '2023-04-17 22:53:25', 1),
(2670881, '2023-04-17 13:41:19', 3),
(3241290, '2023-04-02 17:07:55', 1),
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
(3749414, '2023-04-16 01:53:27', 1),
(3749415, '2023-04-16 01:52:34', 1),
(3918149, '2023-04-16 00:32:01', 1),
(4237597, '2023-04-16 02:00:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seen_movies`
--

CREATE TABLE `seen_movies` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabulka viděných filmů.';

--
-- Dumping data for table `seen_movies`
--

INSERT INTO `seen_movies` (`user_id`, `movie_id`, `timestamp`) VALUES
(1, 671, '2023-04-10 18:02:36'),
(1, 672, '2023-04-10 18:02:30'),
(1, 1771, '2023-04-10 18:01:31'),
(1, 1893, '2023-04-11 02:22:12'),
(1, 19995, '2023-04-10 18:01:50'),
(1, 24428, '2023-04-10 18:01:35'),
(1, 36993, '2023-04-18 01:14:19'),
(1, 36994, '2023-04-18 01:14:45'),
(1, 75023, '2023-04-11 02:30:02'),
(1, 76600, '2023-04-18 23:49:59'),
(1, 181808, '2023-04-11 02:28:03'),
(1, 300619, '2023-04-16 03:58:14'),
(1, 502356, '2023-04-18 00:53:16'),
(1, 593643, '2023-04-10 17:42:48'),
(1, 594767, '2023-04-13 01:15:20'),
(1, 603692, '2023-04-16 15:09:38'),
(1, 640146, '2023-04-10 18:02:09'),
(1, 700391, '2023-04-16 04:08:32'),
(1, 980078, '2023-04-10 18:02:13'),
(3, 496, '2023-04-13 23:40:29'),
(3, 76600, '2023-04-13 23:38:39'),
(3, 502356, '2023-04-17 15:43:04'),
(3, 594767, '2023-04-13 23:38:42'),
(3, 603692, '2023-04-13 23:38:45'),
(3, 700391, '2023-04-17 15:43:07'),
(3, 758323, '2023-04-17 15:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `tv_shows`
--

CREATE TABLE `tv_shows` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `poster_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_shows`
--

INSERT INTO `tv_shows` (`id`, `name`, `original_name`, `poster_path`) VALUES
(456, 'Simpsonovi', 'The Simpsons', '/poTtFCp1LjEl187NuqD6ekFplb6.jpg'),
(4194, 'Star Wars: Klonové války', 'Star Wars: The Clone Wars', '/e1nWfnnCVqxS2LeTO3dwGyAsG2V.jpg'),
(19384, 'Comeback', 'Comeback', '/jBhF1ZoMDb4EPYgFmgRQY7CY9yP.jpg'),
(36361, 'Ulice', 'Ulice', '/3ayWL13P1HeRnyVL9lU9flOdZjq.jpg'),
(45783, 'Kuroko\'s Basketball', '黒子のバスケ', '/ftT1qtT6yWO5rfs237a466N8QRr.jpg'),
(52698, 'الكبير أوي', 'الكبير أوي', '/yOyoBsVGGmSAsvvgJ1NAi7GHR1j.jpg'),
(60554, 'Star Wars: Povstalci', 'Star Wars Rebels', '/jmgR8330sKEJehr27rQ3bODnrlP.jpg'),
(67744, 'MINDHUNTER: Lovci myšlenek', 'Mindhunter', '/fbKE87mojpIETWepSbD5Qt741fp.jpg'),
(82856, 'Mandalorian', 'The Mandalorian', '/6upwFpQr6XqQenoWZ9rFnjCUpTv.jpg'),
(85328, 'MOST!', 'MOST!', '/iQZX4bdLEpXIBJYmSxE1IKJWthj.jpg'),
(88329, 'Hawkeye', 'Hawkeye', '/uQdAET8dl403BIVktl5gjtzXRDT.jpg'),
(94605, 'Arcane', 'Arcane', '/fqldf2t8ztc9aiwn3k6mlX3tvRT.jpg'),
(100088, 'The Last of Us', 'The Last of Us', '/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg'),
(101604, 'قلبي اطمأن', 'قلبي اطمأن', '/3iNT3rKs8q7qDr1fWxfznimZ7JV.jpg'),
(101978, 'Disney Galerie - Star Wars: Mandalorian', 'Disney Gallery / Star Wars: The Mandalorian', '/6Hc2eHp59iTyMqkhcumNovq2l6y.jpg'),
(114461, 'Ahsoka', 'Ahsoka', '/kw0oydRUsqDohUKiF4LKkG8tDIm.jpg'),
(196080, 'منهو ولدنا؟', 'منهو ولدنا؟', '/nEtzUtqVri3v5vyOYdajc4nA9m6.jpg'),
(203057, 'Melur Untuk Firdaus', 'Melur Untuk Firdaus', '/rVxQxsY3bQWTabHUi2Qr3aoOafk.jpg'),
(209085, 'Amor Perfeito', 'Amor Perfeito', '/aOPhyvHDauWFuc3rthpHArCNyrm.jpg'),
(213713, 'Faltu', 'Faltu', '/lgyFuoXs7GvKJN0mNm7z7OMOFuZ.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tv_show_episodes`
--

CREATE TABLE `tv_show_episodes` (
  `id` bigint(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `season_number` smallint(6) NOT NULL,
  `episode_number` smallint(11) NOT NULL,
  `air_date` date NOT NULL,
  `runtime` smallint(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tv_show_episodes`
--

INSERT INTO `tv_show_episodes` (`id`, `show_id`, `season_number`, `episode_number`, `air_date`, `runtime`, `name`) VALUES
(35007, 615, 1, 2, '1999-04-04', 23, ''),
(35008, 615, 1, 3, '1999-04-06', 23, ''),
(35013, 615, 1, 8, '1999-05-11', 23, ''),
(35014, 615, 1, 9, '1999-05-18', 23, ''),
(286589, 4194, 2, 1, '2009-10-02', 22, 'Krádež Holokronu'),
(286590, 4194, 2, 3, '2009-10-09', 22, 'Děti Síly'),
(286609, 4194, 2, 2, '2009-10-02', 22, 'Zásilka zkázy'),
(574647, 19384, 2, 14, '2011-09-05', 30, 'Zabijačka'),
(574648, 19384, 2, 16, '2011-09-19', 30, 'Holter'),
(574649, 19384, 2, 15, '2011-09-12', 30, 'Sulc'),
(904465, 45783, 1, 1, '2012-04-08', 24, '1. epizoda'),
(904466, 45783, 1, 2, '2012-04-15', 24, '2. epizoda'),
(904467, 45783, 1, 3, '2012-04-22', 24, '3. epizoda'),
(1010972, 60554, 1, 3, '2014-10-27', 22, 'Tajemství starých mistrů'),
(1053814, 60554, 1, 2, '2014-10-20', 22, 'Ukradená stíhačka'),
(1053815, 60554, 1, 1, '2014-10-13', 22, 'Droidi v nesnázích'),
(1337906, 67744, 1, 1, '2017-10-13', 60, '1. epizoda'),
(1379139, 67744, 1, 2, '2017-10-13', 56, '2. epizoda'),
(1379140, 67744, 1, 3, '2017-10-13', 45, '3. epizoda'),
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
(1857024, 82856, 1, 2, '2019-11-15', 34, 'Kapitola 2: Dítě'),
(1953812, 94605, 1, 1, '2021-11-06', 43, 'Tak vás tu vítáme'),
(1980403, 82856, 1, 3, '2019-11-22', 39, 'Kapitola 3: Hřích'),
(1980404, 82856, 1, 4, '2019-11-29', 43, 'Kapitola 4: Útočiště'),
(1987335, 82856, 1, 5, '2019-12-06', 37, 'Kapitola 5: Pistolník'),
(1987336, 82856, 1, 6, '2019-12-13', 45, 'Kapitola 6: Vězeň'),
(1987337, 82856, 1, 7, '2019-12-18', 42, 'Kapitola 7: Zúčtování'),
(2023593, 82856, 1, 8, '2019-12-27', 50, 'Kapitola 8: Vykoupení'),
(2181581, 100088, 1, 1, '2023-01-15', 81, 'Když se ztratíš v temnotě'),
(2215166, 101604, 1, 1, '2018-05-17', 30, '1. epizoda'),
(2223971, 101604, 1, 2, '2018-05-19', 30, '2. epizoda'),
(2228037, 101978, 1, 1, '2020-05-04', 32, 'Režie'),
(2257675, 101978, 1, 2, '2020-05-08', 28, 'Odkaz'),
(2261049, 101978, 1, 3, '2020-05-15', 25, 'Obsazení'),
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
(2670881, 88329, 1, 1, '2021-11-24', 51, 'Hrdinům se vyhýbej'),
(3241290, 94605, 1, 2, '2021-11-06', 40, 'Některá tajemství je lepší nechat být'),
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
(3749414, 203057, 1, 1, '2022-05-27', 42, '1. epizoda'),
(3749415, 203057, 1, 2, '2022-05-28', 42, '2. epizoda'),
(3749419, 203057, 1, 6, '2022-06-04', 42, '6. epizoda'),
(3749420, 203057, 1, 7, '2022-06-08', 42, '7. epizoda'),
(3918149, 209085, 1, 1, '2023-03-20', 47, '1. epizoda'),
(4071039, 100088, 1, 2, '2023-01-22', 53, 'Nakažení'),
(4071040, 100088, 1, 3, '2023-01-29', 77, 'Long Long Time'),
(4071041, 100088, 1, 4, '2023-02-05', 47, 'Drž mě za ruku'),
(4071042, 100088, 1, 5, '2023-02-12', 60, 'Vydržet a přežít'),
(4071043, 100088, 1, 6, '2023-02-19', 61, 'Rodina'),
(4071045, 100088, 1, 7, '2023-02-26', 57, 'Napospas'),
(4071046, 100088, 1, 8, '2023-03-05', 52, 'V časech nouze'),
(4071047, 100088, 1, 9, '2023-03-12', 46, 'Hledej světlo'),
(4082902, 82856, 3, 1, '2023-03-01', 37, 'Kapitola 17: Odpadlík'),
(4237589, 82856, 3, 2, '2023-03-08', 45, 'Kapitola 18: Doly na Mandaloru'),
(4237591, 82856, 3, 3, '2023-03-15', 58, 'Kapitola 19: Obrácení'),
(4237593, 82856, 3, 4, '2023-03-22', 33, 'Kapitola 20: Nalezenec'),
(4237594, 82856, 3, 5, '2023-03-29', 44, 'Kapitola 21: Pirát'),
(4237596, 82856, 3, 6, '2023-04-05', 46, 'Kapitola 22: Žoldnéři'),
(4237597, 82856, 3, 7, '2023-04-12', 53, 'Kapitola 23: Spiknutí');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `watch_limit` smallint(6) NOT NULL,
  `public_profile` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabulka uživatelů.';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `watch_limit`, `public_profile`) VALUES
(1, 'vojtechnerad', 'Vojtěch', 'Nerad', 'nerv01@vse.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-05 02:05:14', 500, 0),
(2, 'nejakejuzivatel', 'Nějakej', 'Uživatel', 'nejakej@uzivatel.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 22:30:13', 180, 0),
(3, 'jannovak', 'Jan', 'Novák', 'j@novak.cz', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 21:44:29', 120, 1),
(4, 'dalsiuzivatel', 'Další', 'Uživatel', 'dalsi.uzivatel@xd.cz', '', '2023-04-13 18:21:23', 500, 0),
(5, 'dasdad', 'asd', 'dasd', 'dalsi.uzivatel@xd.czd', '$2y$10$PEd7r4J2fT0VdsI2ImSmCeFfZum5qaYotYP4A9S7mwMhzrl.J.yn2', '2023-04-13 22:29:21', 500, 1),
(6, 'tomasdvorak', 'Tomáš', 'Dvořák', 'tomduben@xd.cz', '', '2023-04-13 18:49:47', 500, 0),
(7, 'ahmed', 'Machmut', 'Shipkowy', 'm.s@xd.cz', '', '2023-04-13 18:50:42', 12, 0),
(8, 'asdasdasdasdasd', 'asdfasdfasdfasdfasdfasdf', 'adfasdfasdfasdfasdfasdfasdf', 'j@novaxdk.cz', '', '2023-04-13 18:51:05', 555, 0),
(9, 'asdasd', 'aasdfasdf', 'asdfafs', 'j@nodsdsvak.cz', '', '2023-04-13 18:51:51', 231, 0),
(11, 'asdasdsd', 'aasdfasdf', 'asdfafs', 'j@nodsdsdsvak.cz', '', '2023-04-13 18:52:02', 231, 0),
(12, 'asdasxddsd', 'aasdfasdf', 'asdfafs', 'j@nodsdsxddsvak.cz', '', '2023-04-13 18:52:14', 231, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarked_movies`
--
ALTER TABLE `bookmarked_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexes for table `bookmarked_tv_shows`
--
ALTER TABLE `bookmarked_tv_shows`
  ADD PRIMARY KEY (`user_id`,`show_id`);

--
-- Indexes for table `favorite_tv_shows`
--
ALTER TABLE `favorite_tv_shows`
  ADD PRIMARY KEY (`user_id`,`show_id`);

--
-- Indexes for table `friendslist`
--
ALTER TABLE `friendslist`
  ADD PRIMARY KEY (`requesterId`,`adresseeId`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `seen_episodes`
--
ALTER TABLE `seen_episodes`
  ADD PRIMARY KEY (`id`,`user_id`);

--
-- Indexes for table `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD PRIMARY KEY (`user_id`,`movie_id`);

--
-- Indexes for table `tv_shows`
--
ALTER TABLE `tv_shows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_show_episodes`
--
ALTER TABLE `tv_show_episodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seen_movies`
--
ALTER TABLE `seen_movies`
  ADD CONSTRAINT `user_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
