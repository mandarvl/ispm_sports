<div class="round round-one">
  <div>
  <div class="team-top">
  Team 1
  </div>

  <div class="team-bottom">
    Team 2
  </div>
  </div>
  <div>
  <div class="team-top">
  Team 3
  </div>

  <div class="team-bottom">
    Team 4
  </div>
  </div>
  <div>
  <div class="team-top">
  Team 5
  </div>

  <div class="team-bottom">
    Team 6
  </div>
  </div>
  <div>
  <div class="team-top">
  Team 7
  </div>

  <div class="team-bottom">
    Team 8
  </div>
  </div>
</div>

<div class="round round-two">
  <div>
    <div class="team-top">
    Team 1
    </div>
    <div class="team-bottom">
      Team 2
    </div>
  </div>
  
    <div>
      <div class="team-top">
      Team 3
      </div>
      <div class="team-bottom">
        Team 4
      </div>
    </div>
</div>

<style>
 body {
	background: #16a085;
	display: flex;
  flex-flow: row;
  flex-basis: auto;
  min-height: 100vh;
}

.round {
  display: flex;
  flex-flow: column;
  width: 15%;
  justify-content: space-around;
}

.space {
  min-height: 30px;
  min-height: 80%;
  border-right: 1px solid black;
}

.round.round-two {
  justify-content: space-around;
}

.matchup {
  margin-bottom: 25%;
}

.team-top {
	border-bottom: 1px solid black;
	padding: .2em;
  padding-left: .5em;
}

.team-bottom {
	border-top: 1px solid black;
	padding: .2em;
  padding-left: .5em;
}
</style>