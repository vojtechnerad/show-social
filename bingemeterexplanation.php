<?php
$title = 'Co je to Binge Meter? • Show Social';
$active_page = 'profile';
include 'includes/header.inc.php';
?>
<h1>Binge Meter</h1>

<h3>Co to je</h3>
<p>Binge Meter je speciální ukazatel, zobrazující kolik času uživatel strávil sledováním filmů a seriálů.</p>

<h3>Jak funguje</h3>
<p>Binge Meter počítá podíl mezi celkovým počtem nasledovaného času na filmech a seriálech za posledních 24 hodin, a soft limitem, který si uživatel předem nastavil.</p>
<p>Jelikož jde o podíl těchto dvou čísel, možné hodnoty kterých ukazatel Binge Meter může nabývat</p>
<ul>
    <li>0 &rarr; pokud uživatel neshlédl za den žádnný film ani epizodu</li>
    <li>1 až 99 &rarr; pokud uživatel shlédl obsah v délce menší než jím nastavený limit</li>
    <ul>
        <li><span class="text-white bg-success">1 až 79</span> je označeno zeleně a signalizuje že uživatel má daleko ke svému dennímu limitu</li>
        <li><span class="text-white bg-warning">80 až 99</span> je označeno žlutě a signalizuje že se uživatel blíží ke svému dennímu limitu</li>
        <li><span class="text-white bg-danger">100 a více</span> je označeno zeleně a signalizuje že uživatel překročil svůj denní limit a měl by pro daný den ukončit sledování</li>
    </ul>
    <li>100 a více &rarr; pokud uživatel shlédl obsah v délce svého limitu a více</li>
</ul>

<h3>K čemu slouží</h3>
<p>Binge watching, pojem známý jen několik málo let, se používá v souvislosti s televizními seriály. Označuje zhlédnutí velkého množství dílů seriálu (nebo i filmů, které mají několik dílů) v nepřetržitém sledu. V současné době se jedná o velmi oblíbený způsob sledování televizních seriálů především u mladé generace.</p>
<p>Podle odborníků se s binge watchingem pojí řada potenciálních zdravotních rizik. Přece jenom člověk při sledování seriálů či filmů sedí klidně i po několik hodin.</p>
<p>Pomocí Binge Metru tato stránka chce upozornit uživatele o jejich stavu zhlédnutých filmů či seriálů za daný den. A odratit je tak od dalšího nekončícího sledování 'dalšího jednoho dílu'.</p>
<?php
include 'includes/footer.inc.php';
?>
