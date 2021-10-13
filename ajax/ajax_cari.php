<?php

require_once("../functions.php");

$pelajar = search($_GET['keyword']);

?>

<div class="row tableDiv <?php if (count($pelajar) === 0) : ?> emptyTable <?php elseif (count($pelajar) === 1) : ?> oneData <?php endif; ?>">
  <table class="table table-striped ">
    <thead>
      <tr class="text-center">
        <th scope="col">No</th>
        <th scope="col">Gambar</th>
        <th scope="col">Nama</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>

    <?php $i = 1; ?>

    <tbody class="align-middle text-center">
      <?php foreach ($pelajar as $row) : ?>
        <tr>
          <th scope="row"><?= $i++; ?></th>
          <td>
            <img class="imageData" src="images/<?= $row['gambar']; ?>" width="100" alt="">
          </td>
          <td><?= $row['nama']; ?></td>
          <td><a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-primary"><i class="me-2 fas fa-info-circle"></i>Lihat Detail</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if (count($pelajar) === 0) : ?>
    <div class="row px-5 text-center justify-content-center">
      <div class="col-10">
        <img src="emptyTable.svg" class="w-25 mt-4 mb-3" alt="">
        <h2 class="text-secondary">Data Pelajar Tidak Ada</h2>
      </div>
    </div>
  <?php endif; ?>
</div>