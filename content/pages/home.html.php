<?php
use app\models\{Challenge, Submission, Player};

	$set = Challenge::currentSet();
	$scores = Player::scoreboardForSet($set);
	$challenges_in_set = Challenge::findAsArray(['setnr' => $set]);
	$weeks = sizeof($challenges_in_set);
?>
<h2>Current set scoreboard</h2>

<table>
	<thead>
		<tr>
			<!-- <th>id</th> -->
			<th>Player</th>
			<th>Total</th>
			<?php 
			for ($w=1; $w <= $weeks; $w++) { 
				echo "<th>Week #{$w}</th>";
			}
			?>
		</tr>
	</thead>
	<tbody><?php 
	foreach ($scores as $row) : ?>
		<tr>
			<td><?=$row['player']?></td>
			<td><?=$row['total']?></td>
			<?php
			for ($i=0; $i < $weeks; $i++) { 
				if (isset($row['week'][$i])) {
					$week = $row['week'][$i];
					$sc = $week['score']; $st = "";
					for ($i=0; $i < (int) $week['stars'] ; $i++) { 
						$st .= '*';
					} 
					for ($i=0; $i < 2 - (int) $week['stars'] ; $i++) { 
						$st .= '_';
					}
					echo "<td>{$sc} {$st}</td>";
				} else {
					echo '<td>&nbsp;</td>';
				}
			}
			?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<br />
<hr />

<h2>Challenges</h2>
<table>
	<thead>
		<tr>
			<!-- <th>id</th> -->
			<th>Name</th>
			<th>Set</th>
			<th>Week</th>
			<th>Background</th>
			<th>Gods</th>
			<th>Species</th>
			<th>Submissions</th>
			<th>Scores</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
		$challenges = Challenge::findBySets();
		foreach ($challenges as $c) :
	?>
		<tr>
			<td><?=$c->name?></td>
			<td><?=$c->setnr?></td>
			<td><?=$c->week?></td>
			<td><?=$c->background?></td>
			<td><?=$c->gods?></td>
			<td><?=$c->species?></td>
			<td><?=$c->subs?></td>
			<td><a href="/challenges/scores?id=<?=$c->id?>">See scores</a></td>
		</tr>
	<?php
		endforeach;
	?>
	</tbody>
</table>