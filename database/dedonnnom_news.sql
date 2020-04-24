-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 22, 2020 alle 23:37
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appartengono`
--

CREATE TABLE `appartengono` (
  `idCategoria` int(11) NOT NULL,
  `idNews` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `appartengono`
--

INSERT INTO `appartengono` (`idCategoria`, `idNews`) VALUES
(1, 3),
(1, 26),
(3, 3),
(3, 26),
(4, 4),
(4, 8),
(5, 6),
(5, 8),
(6, 7),
(7, 32);

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `idCategoria` int(11) NOT NULL,
  `nomeCategoria` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`idCategoria`, `nomeCategoria`) VALUES
(6, 'Developer'),
(7, 'Gaming'),
(4, 'Sicurezza informatica'),
(5, 'Smart working'),
(3, 'Smartphone'),
(1, 'Tecnologia');

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `idCommento` int(11) NOT NULL,
  `testo` text NOT NULL,
  `idUser` int(11) NOT NULL,
  `idNews` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`idCommento`, `testo`, `idUser`, `idNews`) VALUES
(1, 'Peccato. Sembra un ottimo smartphone.', 58, 3),
(2, 'Io lo compro lo stesso. YEAH!', 62, 3),
(3, 'Perchè usare whatsapp quando esistono alternative cento volte migliori?', 62, 8),
(4, 'Aggiorno subito!', 58, 7),
(5, 'Me gusta el windows!', 81, 7),
(6, 'Che schifo la apple!', 79, 26),
(7, 'Hai ragione luigino', 58, 26),
(8, 'Molto bello. Peccato che se gioco in vr vomito le cozze del pranzo!', 87, 32),
(9, 'Che schifo samuele@news.it', 62, 32);

-- --------------------------------------------------------

--
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `idNews` int(11) NOT NULL,
  `titolo` varchar(200) NOT NULL,
  `testo` text NOT NULL,
  `dataPubblicazione` date NOT NULL,
  `linkImmagine` varchar(256) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `news`
--

INSERT INTO `news` (`idNews`, `titolo`, `testo`, `dataPubblicazione`, `linkImmagine`, `idUser`) VALUES
(3, 'Bug vistoso per Galaxy S20 Ultra: il display vira sul verde', 'L’ultimo aggiornamento software rilasciato per Galaxy S20 Ultra, quello che ha introdotto le patch di aprile 2020, non è stato felicissimo per i possessori della variante dello smartphone con processore Exynos, quella commercializzata anche in Italia. L’aggiornamento ha introdotto un fastidioso bug al display.\r\n\r\nIl problema consiste nel viraggio della tinta del display verso il verde quando quest’ultimo lavora a una frequenza di aggiornamento superiore a 60 Hz. Diversi utenti si sono accorti del problema, ben visibile a luminosità bassa. Le app con le quali è stato osservato sono diverse: Samsung Pay, Fotocamera, Calcolatrice, Snapchat, Telegram, PUBG: Mobile e Chrome. Sembra anche che il problema si presenti più facilmente quando il dispositivo si trova a una temperatura maggiore ai 40°C e la batteria si trova a un livello di carica basso.\r\nLEGGI ANCHE: Samsung Galaxy S20 Ultra, la recensione\r\n\r\nSecondo SamMobile, il problema potrebbe presentarsi anche quando si accede ad app che non supportano refresh rate superiori a 60 Hz. Fortunatamente sembra un problema esclusivamente software: si risolverebbe mediante un reset ai dati di fabbrica e non era stato riscontrato prima dell’aggiornamento delle patch ad aprile 2020.\r\n\r\nSamsung non ha ancora commentato ufficialmente la vicenda, presumiamo che si metterà a lavoro su un fix software appena verrà a conoscenza del problema. Fateci sapere se avete riscontrato il bug e quanto vi da fastidio.', '2020-04-19', 'https://www.androidworld.it/wp-content/uploads/2020/02/Samsung-Galaxy-S20-Ultra-5G-final-015.jpg', 62),
(4, 'Pasticcio Clearview: esposto il codice sorgente', 'A renderlo noto Mossab Hussein, ricercatore esperto di sicurezza informatica della società SpiderSilk con sede a Dubai. Un errore di configurazione individuato in uno dei server gestiti dall’azienda ha permesso a lui (e potenzialmente a chiunque in possesso di una connessione Internet) di accedere a un repository contenente il codice oltre che i client destinati a Windows, macOS, Android e iOS, incluse alcune versioni in fase di test e non ancora distribuite. Presenti poi conversazioni del team gestite su Slack, in chiaro e non protette da alcuna password.\r\n\r\nNell’archivio inoltre riferimenti al prototipo di Insight (una videocamera la cui realizzazione è stata abbandonata) e 70.000 video catturati proprio da un’unità preliminare del dispositivo installata in un edificio residenziale di Manhattan con il via libera del gestore.\r\n\r\nUn ennesimo grattacapo per Clearview, capace in breve tempo di attirare su di sé le ire di realtà come Google, Facebook e Twitter per aver eseguito senza autorizzazione lo scraping dei contenuti pubblicati dagli utenti sulle rispettive piattaforme così da sfruttarli al fine di istruire i propri algoritmi. A fine febbraio è poi spuntato in Rete l’elenco dei clienti che hanno già scelto di mettere mano al portafogli per usufruire della tecnologia: tra questi anche NBA a Walmart, fino a Bank of America. Pochi giorni dopo l’applicazione iOS è stata bloccata da Apple, appena prima che circolassero in Rete informazioni tali da poter definire l’IA un giocattolo per ricchi.', '2020-04-19', 'https://www.punto-informatico.it/app/uploads/2020/04/clearview-1060x424.jpg', 63),
(6, 'Smart Working: legge ed evoluzione normativa del Lavoro Agile', 'Lo Smart Working in Italia è legge! Dopo un primo periodo sperimentale caratterizzato da vuoti legislativi e parecchia confusione terminologica, la Legge n.81 del 22 maggio 2017 (anche detta Legge sul Lavoro Agile) ha finalmente regolato la materia del lavoro da remoto. La normativa definisce lo Smart Working in tutti suoi aspetti giuridici: diritti dello smart worker e controllo da parte del datore di lavoro, strumenti tecnologici e modalità con cui viene eseguita l\'attività da remoto.\r\nL\'articolo 18 della Legge n.81/2017 (dall\'esplicativo titolo \"Misure per la tutela del lavoro autonomo non imprenditoriale e misure volte a favorire l\'articolazione flessibile nei tempi e nei luoghi del lavoro subordinato\") fornisce una definizione di Lavoro Agile improntata su flessibilità organizzativa, volontarietà delle parti e adozione di strumentazione tecnologica.\r\nOltre a fornire quest\'importante definizione di Lavoro Agile, la norma disciplina alcuni aspetti legati alla materia come la necessità di un accordo scritto di Smart Working concordato tra datore di lavoro e lavoratore il quale espliciti l’esecuzione della prestazione lavorativa al di fuori dei locali aziendali, la durata dell’accordo, il rispetto dei tempi di riposo e del diritto alla disconnessione e le modalità di recesso.\r\n\r\nAltri elementi rilevanti sono:\r\n\r\n    la parità di trattamento economico e normativo;\r\n    il diritto all’apprendimento permanente;\r\n    gli aspetti legati alla salute e alla sicurezza.\r\n\r\nSu quest’ultimo aspetto i lavoratori che decidono di aderire a un accordo di Smart Working sono tutelati in caso di infortuni e malattie professionali per quelle prestazioni che decidono di effettuare all’esterno dei locali aziendali sia quando si trovano in itinere.\r\n', '2020-04-19', NULL, 58),
(7, 'Windows 10 20H1, il nuovo feature update è in arrivo', 'Windows 10 20H1, o la versione 2004 come spesso verrà chiamata dalla stessa Microsoft nei prossimi mesi, è in dirittura d\'arrivo. Si tratta dell\'aggiornamento con feature della prima metà dell\'anno, il primo da diverso tempo con novità vere e proprie: sebbene formalmente Windows 10 1909 (o November 2019 Update) sia stato un aggiornamento \"maggiore\", di fatto le novità sono state davvero poche e anche l\'impronta del download (pochi megabyte) era decisamente contenuta rispetto alla prassi di Microsoft per quanto riguarda gli aggiornamenti più importanti.\r\n\r\nPer via delle diverse lamentele in fatto di stabilità e affidabilità apparse online con le precedenti versioni di Windows 10, Microsoft aveva deciso di approntare un rilascio più cautelativo, con un aggiornamento che ha solo rifinito i cambiamenti della versione precedente importando solo pochissime novità (di entità poco importante). Anche per Windows 10 20H1 la storia non cambia tantissimo: sebbene Microsoft abbia dedicato un lungo periodo di test e formalmente sia un aggiornamento importante, le sue dimensioni saranno decisamente contenute.\r\nL\'esperienza di Cortana, assistente virtuale Microsoft che non ha mai preso il volo in un mercato decisamente competitivo, verrà totalmente rivoluzionata. La nuova versione perde tutti i fronzoli legati alla musica, al controllo della smart home e alle funzionalità di terze parti per concentrarsi sulla produttività. Cortana \"muore\" sulle piattaforme di terze parti e non ha più il supporto ufficiale da parte di Microsoft su iOS e Android, mentre su Windows 10 viene proposto in una finestra che può essere trascinata in ogni parte dello schermo. Non è più ancorata, quindi, alla barra delle applicazioni, e può essere lanciata anche attraverso un tasto da tastiera. L\'interfaccia è simile a quella di una chat, che riporta la cronologia delle conversazioni con l\'assistente.\r\n\r\nFra le skill legate alla produttività abbiamo ad esempio alcune nuove possibilità: possibilità di inviare o controllare le e-mail, vedere gli appuntamenti imminenti, impostare nuovi eventi.', '2020-04-19', 'https://wips.plug.it/cips/tecnologia/cms/2020/04/aggiornamenti-windows-10.jpg?w=738&a=c&h=415', 78),
(8, 'WhatsApp: come fare videochiamate con più di 4 utenti', 'La nuova funzione è stata scovata grazie al programma beta di WhatsApp, disponibile su iOS e Android.\r\n\r\nIn particolare, come sottolineato da WABetainfo, le versione dedicate all’introduzione di questa funzionalità sono le versioni beta 2.20.50.25 su iOS e 2.20.133 su Android.\r\n\r\nTutto quello che dovete fare è iscrivervi ai relativi programmi di prova per i due sistemi operativi mobile. Per farlo dovrete rivolgervi alla piattaforma Testflight se possedete un iPhone o scaricare l’app beta direttamente da Play Store se avete uno smartphone Android.\r\n\r\nPer poter ampliare il bacino di partecipanti bisognerà aver installato la beta tra tutti gli utenti che desidereranno connettersi in contemporanea: per fare una videochiamata di gruppo bisognerà affidarsi sempre ai gruppi di WhatsApp, avviandola la videotelefonata apparirà come sempre con 4 utenti in contemporanea ma toccando il tasto dedicato si potrà aggiungere altri utenti alla videochiamata fino a un massimo di 8.\r\n\r\nIn attesa dell’aggiornamento potete procedere secondo questi passaggi per sfruttare al meglio le chiamate video su WhatsApp.\r\n\r\nNon è una sorpresa del resto visto che, con la situazione internazionale dovuta alla pandemia da Coronavirus, le videochiamate sono diventate vitali per tantissime persone, sia per motivi personali che di lavoro ed è quindi normale che nuove funzioni legate a questo aspetto siano diventate prioritarie nello sviluppo dell’app.\r\n\r\nLa nuova funzione è disponibile nell’ultima beta sia per sistemi operativi Google Android che Apple iOS. Per poterla testare è dunque necessario aggiornare la versione beta alla release 2.20.133 per il primo, scaricandola dal Play Store, e 2.20.50.25 da TestFlight per iOS. Tenete presente però che se uno dei partecipanti alla chiamata non possiede la stessa versione, non sarà aggiunto alla chiamata di gruppo. In generale comunque ora, se ci sono più di quattro partecipanti nel gruppo, quando si fa clic sul pulsante di chiamata in un gruppo, WhatsApp chiederà quali contatti si desidera chiamare, altrimenti, se ci sono quattro membri o meno nel gruppo, tutti i partecipanti saranno aggiunti automaticamente alla chiamata\r\n', '2020-04-19', 'https://wips.plug.it/cips/tecnologia/cms/2020/04/whatsapp-chiamate-videochiamate.jpg?w=738&a=c&h=415', 78),
(26, 'iPhone SE 2020 ufficiale!', '<p>Arriva l&rsquo;iPhone economico &egrave; il sogno di tanti fan Apple: l&rsquo;uscita di iPhone SE 2020, noto in precedenza come iPhone 9, &egrave; realt&agrave;, dopo gli insistenti rumor che da diversi mese prevedevano l&rsquo;arrivo di questa nuova versione. Caratteristiche entry level, design che guarda ai vecchi modelli e prezzo d&rsquo;acquisto basso per gli standard Apple: si parte da 499 euro per la versione da 64 GB, con ritorno al tasto home (con 3D Touch) ma un cervello di ultima generazione dato dal chip A13. Le caratteristiche di iPhone SE 2020 aggiornano un design del passato a prestazioni degne dell&rsquo;ultima generazione date dairecenti iPhone 11, 11 Pro e 11 Pro Max fornendo un modello pi&ugrave; piccolo e compatto, anche nel prezzo. Come sappiamo Apple ha di recente puntato su iPhone XR e iPhone 11 per rivolgersi a tutti quegli utenti che desiderano acquistare un nuovo device Apple permettendosi di spendere qualcosa in meno, con gli attuali prezzi che superano abbondantemente i 1000 euro. iPhone SE 2020 punterebbe ad abbassare ancora di pi&ugrave; il prezzo di listino, cavalcando il successo degli attuali iPhone 11 e XR. iPhone SE 2020 punta a tutti gli utenti che non desiderano spendere cifre esose per uno smartphone della mela, andando di fatto a sostituire iPhone 8, ormai presente da un paio d&rsquo;anni in listino, ereditandone alcune peculiari caratteristiche. Se iPhone SE 2020 &egrave; dotato di tutte le caratteristiche tipiche degli ultimi device Apple, come il processore A13 Bionic e una RAM che dovrebbe attestarsi a 3 GB, l&rsquo;aspetto e il design dei materiali che va a ricalcare quelli di iPhone 7 e iPhone 8. Il display resta quindi un IPS 4,7 pollici, con rapporto 16:9 e risoluzione pari a 1334x750 pixel, viene conservato il Touch ID e la fotocamera posteriore &egrave; singola (12 megapixel con apertura f/1.8 unti a un&rsquo;ottica grandangolare) per permettere agli iPhone di fascia alta di differenziarsi ancora di pi&ugrave; (iPhone 11 conta su una doppia fotocamera mentre iPhone 11 Pro ne ha ben tre). E il prezzo? In linea con il vecchio iPhone SE, economico e differente a seconda del modello scelto: 499 euro per la versione da 64 GB di memoria; 549 euro per la versione da 128 GB di memoria; 669 euro per la versione da 256 GB di memoria. Le colorazioni disponibili sono tre, Bianca, Grigio Siderale e PRODUCT (RED) e i preordini sono aperti dalle ore 17:00 del 17 aprile e l&rsquo;uscita ufficiale &egrave; fissata per il 24 aprile. iPhone SE 2020 potrebbe porsi come ottima alternativa per chi possiede ancora iPhone 6 e 6 Plus (modelli esclusi dal nuovo iOS 13, previsto ovviamente nella nuova versione economica).</p>', '2020-04-20', 'assets/img/newsImg/apple-v2-5535-340.jpg', 81),
(32, 'Half-Life Alyx | Recensione: il giorno 0 della realtà virtuale', '<p><em>Oggi non &egrave; che un giorno qualunque di tutti i giorni che verranno, ma ci&ograve; che farai in tutti i giorni che verranno dipende da quello che farai oggi.</em><br /><em>(Ernest Hemingway)</em></p>\r\n<p><strong>Che cos&rsquo;&egrave; per voi la perfezione?</strong> Un dipinto di Caravaggio? Una scultura di Michelangelo? Una sinfonia di Beethoven? Certamente ognuna di queste cose potrebbe, a proprio modo, essere perfetta, pur presentando al tempo stesso delle imperfezioni. &ldquo;<em>La perfezione si ottiene</em>&rdquo; diceva Saint-Exup&eacute;ry &ldquo;<em>non quando non c&rsquo;&egrave; pi&ugrave; nulla da aggiungere, ma quando non c&rsquo;&egrave; pi&ugrave; niente da togliere</em>.&rdquo;</p>\r\n<p>Dal punto di vista etimologico &ldquo;perfetto&rdquo; non significa privo di imperfezioni. Significa &ldquo;compiuto&rdquo;. Perfetto dunque &egrave; ci&ograve; che cos&igrave; buono al punto che nulla di simile potrebbe essere migliore. Perfetto &egrave; ci&ograve; che ha raggiunto il proprio scopo.</p>\r\n<p>Valve con Half-Life Alyx lo ha raggiunto. Ha creato qualcosa che oggi non potrebbe essere migliore. Qualcosa di compiuto. A cui difficilmente si potrebbe aggiungere qualcosa. E a cui sicuramente non vorrei togliere alcunch&eacute;.</p>\r\n<div>\r\n<div class=\"edinet_adv_container \">&nbsp;</div>\r\n</div>\r\n<p data-insertion=\"1\" data-parent-tag-name=\"body\"><strong>Per me dunque Half-Life Alyx &egrave; perfezione.</strong></p>\r\n<p>Ve lo dir&ograve; con franchezza: mettetevi il cuore in pace. Non &egrave; necessario percorrere l&rsquo;intero arco narrativo del gioco. Basta la prima mezz&rsquo;ora in Half-Life Alyx per capire quale sar&agrave; il GOTY 2020.&nbsp;Credetemi, non c&rsquo;&egrave; <a href=\"https://www.tomshw.it/videogioco/doom-eternal-guida-completa/\" target=\"_blank\" rel=\"noopener\">Doom Eternal</a> che tenga (PS: &egrave; fantastico, giocatelo!). E no, non ho bisogno di giocare Dying Light 2, <a href=\"http://www.tomshw.it/videogioco/cyberpunk-2077-4/\" target=\"_blank\" rel=\"noopener\">Cyberpunk 2077</a>, Ghost of Tsushima, Halo Infinite o <a href=\"https://www.tomshw.it/videogioco/the-last-of-us-part-ii-trama-gameplay-e-data-di-uscita/\" target=\"_blank\" rel=\"noopener\">The Last of Us Part II</a> per stabilirlo con assoluta certezza. E chiedo scusa per quelli che non ho citato. Ma <strong>Half-Life Alyx gioca in un&rsquo;altra categoria</strong>.</p>\r\n<p>Ognuno dei titoli menzionati potr&agrave; eccellere nel comparto tecnico, in quello narrativo o nel gameplay. O in anche in tutti questi messi assieme! Cose che comunque al titolo Valve non fanno difetto. Ma sicuramente nessuno potr&agrave; anche solo avvicinare<strong> l&rsquo;ambizione e il coraggio di Half-Life Alyx</strong>.</p>\r\n<p>L&rsquo;ambizione di andare oltre i limiti imposti non solo dalla tecnologia, ma anche dalle consuetudini dei videogiocatori. E coraggio nell&rsquo;accettarne le estreme conseguenze: Half-Life Alyx risulta giocabile esclusivamente in VR ed esclusivamente sulla piattaforma pi&ugrave; potente che ci sia oggi: il PC. E non tiratemi in ballo la &ldquo;Master Race&rdquo; per favore&hellip; qui si parla di semplice necessit&agrave;. Il PC ad oggi &egrave; l&rsquo;unica piattaforma che possa far girare un gioco come questo.</p>\r\n<div>\r\n<div class=\"edinet_adv_container \">&nbsp;</div>\r\n</div>\r\n<p data-insertion=\"1\" data-parent-tag-name=\"body\">Le cose stanno cos&igrave;, volenti o nolenti: <strong>questo &egrave; IL gioco del 2020</strong>. Quello che tutti dovrebbero giocare. E quello che purtroppo non tutti giocheranno&hellip;</p>\r\n<p>Ma io ho un obiettivo e ce l&rsquo;aveva anche Valve quando ha deciso di percorrere questa strada. Quando ha deciso, contro ogni previsione e logica, di tradurre in realt&agrave; il sogno di tutti quegli appassionati che non si erano mai arresi all&rsquo;idea che non ci sarebbe pi&ugrave; stato un Half-Life. E che, da un suo ritorno, si aspettavano qualcosa di grandioso. Quell&rsquo;obiettivo, che poi &egrave; un sogno, vede ognuno di voi con un visore VR in casa. Vede <strong>una realt&agrave; virtuale non pi&ugrave; aliena, ma perfettamente calata nella quotidianit&agrave; del nostro esser videogiocatori</strong>. Persa ogni connotazione di tecnologia esclusiva, per diventare realmente inclusiva. Non sostitutiva del gaming come lo conosciamo oggi sia chiaro, ma in affiancamento a esso. Perch&eacute; si tratta di rivoluzione s&igrave;, ma da affrontarsi un passo alla volta. E Half-Life Alyx &egrave; il pi&ugrave; significativo dal 2016. Ossia da quando i visori di realt&agrave; virtuale sono tornati in commercio. Questa volta per restarci.</p>', '2020-04-21', 'assets/img/newsImg/480x270.jpg', 58);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `cognome` varchar(60) NOT NULL,
  `linkFoto` varchar(256) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `aut` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`idUser`, `nome`, `cognome`, `linkFoto`, `email`, `password`, `level`, `aut`) VALUES
(58, 'Matteo', 'De Donno', 'assets/img/userImg/admin@news.it/0.jpeg', 'admin@news.it', '21232f297a57a5a743894a0e4a801fc3', 3, 'Y'),
(62, 'Pippino', 'Yeah', 'assets/img/userImg/pippi@news.it/coding2.png', 'pippi@news.it', 'b8b5797ae41627325d0f6419772cd13b', 2, 'Y'),
(63, 'Giuseppe', 'Colazzo', NULL, 'giuseppe@news.it', '353f9bfab2d01dbb1db343fdaf9ab02e', 2, 'Y'),
(66, 'Mario', 'Merola', NULL, 'mario@news.it', 'de2f15d014d40b93578d255e6221fd60', 1, 'Y'),
(78, 'Sundhar', 'Pichai', 'assets/img/userImg/sundhar@google.it/60.jpeg', 'sundhar@google.it', '968b4fe9cb595ec87533fe82f3642f6e', 2, 'Y'),
(79, 'Luigino', 'Cortese', 'assets/img/userImg/luigino@news.it/saviano.jpg', 'luigino@news.it', '300603ab340a91f50b992ccb206e25cf', 2, 'Y'),
(80, 'Gabriele', 'Mega', NULL, 'gabriele@news.it', '8bc674f8b3278ec1de6112accd643b4f', 2, 'Y'),
(81, 'Pierangelo', 'Bertoli', 'assets/img/userImg/pier@news.it/index.jpeg', 'pier@news.it', 'c72e2158c941635b8ab6c33abcadf6da', 2, 'Y'),
(87, 'Samuele', 'Erroi', 'assets/img/userImg/samuele@news.it/ronaldinho.jpg', 'samuele@news.it', '86e32b59e149100cfe0636143e8e48de', 1, 'Y'),
(88, 'Gianni', 'Ced', 'assets/img/userImg/gianni@news.it/ced.jpeg', 'gianni@news.it', '1bc42179cc24bcc5eeff1b1b2d03657c', 1, 'Y');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appartengono`
--
ALTER TABLE `appartengono`
  ADD PRIMARY KEY (`idCategoria`,`idNews`),
  ADD KEY `idNews` (`idNews`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCategoria`),
  ADD UNIQUE KEY `nomeCategoria` (`nomeCategoria`);

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`idCommento`),
  ADD KEY `idNews` (`idNews`),
  ADD KEY `idUser` (`idUser`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`idNews`),
  ADD KEY `idUser` (`idUser`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `commenti`
--
ALTER TABLE `commenti`
  MODIFY `idCommento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appartengono`
--
ALTER TABLE `appartengono`
  ADD CONSTRAINT `appartengono_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorie` (`idCategoria`),
  ADD CONSTRAINT `appartengono_ibfk_2` FOREIGN KEY (`idNews`) REFERENCES `news` (`idNews`);

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`idNews`) REFERENCES `news` (`idNews`),
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
