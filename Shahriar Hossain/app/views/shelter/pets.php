<link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/shelter/pets.css" />
<div class="pageWrap">
  <h2 class="pageTitle">Manage Available Pets (CRUD)</h2>

  <div class="grid2">
    <div class="card">
      <h3>Add / Update Pet</h3>

      <form id="petForm" enctype="multipart/form-data">
        <input type="hidden" name="pet_id" id="pet_id" />

        <label>Name</label>
        <input name="name" id="name" type="text" placeholder="Buddy" />

        <label>Species *</label>
        <input name="species" id="species" type="text" placeholder="Dog" required />

        <label>Breed *</label>
        <input name="breed" id="breed" type="text" placeholder="Golden Retriever" required />

        <label>Age (years) *</label>
        <input name="age_years" id="age_years" type="number" min="0" max="40" required />

        <label>Gender *</label>
        <select name="gender" id="gender" required>
          <option value="">Select</option>
          <option>Male</option>
          <option>Female</option>
        </select>

        <label>Location</label>
        <input name="location" id="location" type="text" placeholder="Uttara, Dhaka" />

        <label>Personality</label>
        <textarea name="personality" id="personality" rows="3"></textarea>

        <label>Rescued On (YYYY-MM-DD)</label>
        <input name="rescued_on" id="rescued_on" type="text" placeholder="2026-01-20" />

        <label>Rescued By</label>
        <input name="rescued_by" id="rescued_by" type="text" />

        <label>Health Status *</label>
        <select name="health_status" id="health_status" required>
          <option>Vaccinated</option>
          <option>Not Vaccinated</option>
          <option>Under Treatment</option>
        </select>

        <label>Adoption Fee</label>
        <input name="adoption_fee" id="adoption_fee" type="number" step="0.01" min="0" />

        <label>Adoption Status *</label>
        <select name="adoption_status" id="adoption_status" required>
          <option>Available</option>
          <option>Pending</option>
          <option>Adopted</option>
        </select>

        <label>Pet Profile Image (JPG/PNG, max 5MB)</label>
        <input name="pet_image" id="pet_image" type="file" accept=".jpg,.jpeg,.png" />

        <div class="btnRow">
          <button type="submit" class="Browse" id="saveBtn">Save</button>
          <button type="button" class="Get_Started" id="resetBtn">Reset</button>
        </div>

        <p class="msg" id="msg"></p>
      </form>
    </div>

    <div class="card">
      <div class="cardTop">
        <h3>Your Pets</h3>
        <button class="Get_Started" id="refreshBtn">Refresh</button>
      </div>

      <div id="petsList" class="list"></div>
    </div>
  </div>
</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/Assets/js/shelter/pets.js"></script>
