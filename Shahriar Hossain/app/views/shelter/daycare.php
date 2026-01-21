<link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/shelter/daycare.css" />
<div class="pageWrap">
  <h2 class="pageTitle">Daycare System</h2>

  <div class="grid2">
    <div class="card">
      <h3>Scheduling & Availability (Slots)</h3>

      <form id="slotForm">
        <label>Date *</label>
        <input name="slot_date" id="slot_date" type="text" placeholder="YYYY-MM-DD" required />

        <label>Start *</label>
        <input name="start_time" id="start_time" type="text" placeholder="10:00" required />

        <label>End *</label>
        <input name="end_time" id="end_time" type="text" placeholder="18:00" required />

        <label>Capacity *</label>
        <input name="capacity" id="capacity" type="number" min="1" max="50" value="5" required />

        <div class="btnRow">
          <button class="Browse" type="submit">Create Slot</button>
          <button class="Get_Started" type="button" id="refreshSlots">Refresh</button>
        </div>
        <p class="msg" id="dmsg"></p>
      </form>

      <div id="slotsList" class="list"></div>
    </div>

    
  </div>
</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/Assets/js/shelter/daycare.js"></script>
