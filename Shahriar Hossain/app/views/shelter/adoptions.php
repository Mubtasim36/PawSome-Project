<link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/shelter/adoptions.css" />
<div class="pageWrap">
  <h2 class="pageTitle">Manage Adoption Requests</h2>

  <div class="card">
    <div class="cardTop">
      <p class="Description" style="margin:0;">Approve / Reject / Complete adoption requests. Updates pet status automatically.</p>
      <button class="Get_Started" id="refreshA">Refresh</button>
    </div>
    <div id="adoptionsList" class="tableWrap"></div>
    <p class="msg" id="amsg"></p>
  </div>
</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/Assets/js/shelter/adoptions.js"></script>
