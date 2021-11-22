<?php
    function getResultQuery(){
        return "select  @rank := @rank + 1 as 'rank', q.*
from (
select equipes.logo, classes.niveau, filieres.*, gp, score_for gf, score_against ga, score_for - score_against gd, w, l, d, (w * 3) + d as pts
  from equipes join classes join filieres
    inner join
      (select team, sum(score1) score_for
         from
           (select idEquipe1 as team, idSport, score1
              from matchs where idSport=:sport
            union all
            select idEquipe2, idSport, score2
              from matchs where idSport=:sport
           ) qq
         group by team
       ) q1
       on equipes.idEquipe = q1.team
    inner join
      (select idEquipe1 as team, idSport, sum(score2) score_against
         from
           (select idEquipe1, idSport, score2
              from matchs where idSport=:sport
            union all
            select idEquipe2, idSport, score1
              from matchs where idSport=:sport
           ) qq
        group by team
     ) q2
     on equipes.idEquipe = q2.team
   inner join
     (select idEquipe1 as team, count(case when result = 1 then result end) w, count(case when result = 0 then result end) d, count(case when result = -1 then result end) l
       from
         (select idEquipe1, idSport, case when score1 is null or score2 is null then 2 when score1 > score2 then 1 when score1 = score2 then 0 else -1 end result
            from matchs where idSport=:sport
          union all
          select idEquipe2, idSport, case when score1 is null or score2 is null then 2 when score2 > score1 then 1 when score2 = score1 then 0 else -1 end result
            from matchs where idSport=:sport
         ) qq
       group by idEquipe1
     ) q3
     on equipes.idEquipe = q3.team
   inner join
     (select team, count(case when result = 1 then result end) gp
       from 
        (select idEquipe1 as team, idSport, case when score1 is not null and score2 is not null then 1 end result
           from matchs where idSport=:sport
         union all
         select idEquipe2 as team, idSport, case when score1 is not null and score2 is not null then 1 end result
           from matchs where idSport=:sport
        ) qq
       group by team
     ) q4
     on equipes.idEquipe = q4.team and equipes.idClasse = classes.idClasse and classes.idFiliere = filieres.idFiliere where equipes.idTournoi=:tournoi group by equipes.idEquipe
   order by pts desc
) q, (select @rank := 0) z" ;
    }
?>