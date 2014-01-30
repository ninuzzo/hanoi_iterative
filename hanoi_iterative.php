<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Towers of Hanoi</title>
</head>
<body>
<article>
<header>
<h1>Towers of Hanoi</h1>
<p>A non-recursive implementation</p>
</header>
<?php $n = isset($_GET['n']) && (int)$_GET['n'] > 0 ?(int)$_GET['n'] : NULL ?>
<form>
<p>What number of disks ?
<input name="n" type="number" step="1" min="1" value="<?php if ($n) echo $n ?>" />
<input type="submit" /></p>
</form>
<ul>
<?php
$src_script = basename($_SERVER['SCRIPT_NAME']) . 's';
if ($n) {
  # Initially the A post holds all the disks.
  for ($i = 1; $i <= $n; $i++) $k[$i] = 0;

  # The A post is 0, the B post is 1, the C post is 2.
  $a = 'ABC';

  # Set to 1 when the number of disks is odd
  # and to 0 when the number of disks is even.
  $m = $n & 1; # faster than $n % 2

  $s_012 = 1; $s_210 = 2;
  $iter = (1 << $n) - 1; # faster than pow(2, $n) - 1
  for ($l = 1; $l <= $iter; $l++) {
    # The disk to move is a binary function of the move number $l:
    # it is the same number as the position of the rightmost unity bit of $l.
    $d = 0;
    do {
      $p = 1 << $d; # faster than: pow(2, $d)

      $i = ($l & $p) == $p;
      $d++;
    } while (! $i);
    # $d is now the correct disk to move.
 
    $j = $k[$d] + (($m xor ($d & 1)) ? 1 : -1);
    if ($j < 0) $j = 2; elseif ($j > 2) $j = 0;

    # Equivalent, longer code:
    #if ($m) {
    #  /* If m is 1 (the number of disks is odd), the odd-number disks go to posts 
    #     in the sequence 2 to 1 to 0 to 2 to 1 to 0 and so on; the even-numbered 
    #     disks go to posts in the sequence 0 to 1 to 2 to 0 to 1 to 2 and so on. */
    #  if ($d % 2) {
    #    $j = $k[$d] - 1;
    #    if ($j < 0) $j = 2;
    #  } else {
    #    $j = $k[$d] + 1;
    #    if ($j > 2) $j = 0;
    #  }
    #} else {
    #  /* If m is 0 (the number of disks is even), the odd-number disks go to posts 
    #     in the sequence 0 to 1 to 2 to 0 to 1 to 2 and so on; the even-numbered 
    #     disks go to posts in the sequence 2 to 1 to 0 to 2 to 1 to 0 and so on. */
    #  if ($d % 2) {
    #    $j = $k[$d] + 1;
    #    if ($j > 2) $j = 0;
    #  } else {
    #    $j = $k[$d] - 1;
    #    if ($j < 0) $j = 2;
    #  }
    #}
?><li>Move <?php echo $l ?>: from <?php echo $a[$k[$d]] ?>
 to <?php echo $a[$j] ?></li><?php
    $k[$d] = $j;
  }
}
?>
</ul>
<footer>
<p>View this script source code:
<a href="<?php echo $src_script ?>"><?php echo $src_script ?></a></p>
</footer>
</article>
</body>
</html>
