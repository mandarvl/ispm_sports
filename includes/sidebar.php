<?php
$today = date("Y-m-d", time()) ;    
$reqSport = $bdd->query("SELECT * FROM sports ORDER BY libelleSport") ;
$sports = $reqSport->fetchAll() ;

$matchsRecent = array() ;
foreach($sports as $sport){
    $reqRecent = $bdd->prepare("SELECT * FROM matchs WHERE idSport=? AND date < ? ORDER BY date DESC LIMIT 0, 2") ;
    $reqRecent->execute(array($sport->idSport, $today)) ;
    if($reqRecent->rowCount() > 0)
        $matchsRecent[$sport->libelleSport] = $reqRecent->fetchAll() ;
}
?>
<aside id="sidebar">
    <div class="sidebar-content">
        <div class="widget">
            <p class="widget-title">Catégories</p>
            <?php
            if($reqSport->rowCount() == 0){
            ?>
            <p>Aucune activité sportive trouvée</p>
            <?php
            }else{
            ?>
                <ul>
                <?php
                foreach($sports as $sport){
                ?>
                    <li><a href="calendrier.php?sp=<?= $sport->idSport ?>"><?= $sport->libelleSport ?></a></li>
                <?php
                }
                ?>
                </ul>
            <?php
            }
            ?>
        </div>
        <div class="widget">
            <p class="widget-title">Matchs récents</p>
            <?php
            if(!isset($reqRecent) || $reqRecent->rowCount() == 0){
            ?>
                <p>Aucun match récent trouvé</p>
            <?php
            }
            foreach($matchsRecent as $sport=>$matchs){
            ?>
            <p class="tag-box"><?= $sport ?></p>
            <table class="matchs small">
            <?php
            foreach($matchs as $match){
                $teamsInfo = getTeamsInMatch($match) ;
            ?>
                <tr>
                    <td colspan="5" class="date"><?= $match->date ?></td>
                </tr>
                <tr>
                    <td class="logo"><img src="<?= decrypt($teamsInfo[0]->logo) ?>" class="team-logo small"/></td>
                    <td class="team"><?= formatValue($teamsInfo[0]) ?></td>
                    <td class="score"><?= decrypt($match->score1) ?> - <?= decrypt($match->score2) ?></td>
                    <td class="team text-right"><?= formatValue($teamsInfo[1]) ?></td>
                    <td class="logo text-right"><img src="<?= decrypt($teamsInfo[1]->logo) ?>" class="team-logo small"/></td>
                </tr>
            <?php
            }
            ?>
            </table>
            <?php
            }
            ?>
        </div>
    </div>
</aside>