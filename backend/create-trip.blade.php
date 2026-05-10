<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Trip - Traveloop</title>

  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:Arial, Helvetica, sans-serif;
    }

    body{
      background:#f3f4f6;
      display:flex;
    }

    /* SIDEBAR */
    .sidebar{
      width:260px;
      height:100vh;
      background:#1e3a8a;
      color:white;
      padding:30px 20px;
      position:fixed;
      left:0;
      top:0;
      overflow-y:auto;
    }

    .sidebar::-webkit-scrollbar{
      width:6px;
    }

    .sidebar::-webkit-scrollbar-thumb{
      background:rgba(255,255,255,0.3);
      border-radius:10px;
    }

    .logo{
      font-size:32px;
      font-weight:bold;
      margin-bottom:40px;
    }

    .menu{
      list-style:none;
    }

    .menu li{
      margin:20px 0;
    }

    .menu a{
      color:white;
      text-decoration:none;
      font-size:18px;
      padding:12px;
      display:block;
      border-radius:10px;
      transition:0.3s;
    }

    .menu a:hover{
      background:rgba(255,255,255,0.2);
    }

    /* MAIN CONTENT */
    .main{
      margin-left:260px;
      width:calc(100% - 260px);
      padding:40px;
    }

    /* ALERTS */
    .alert-error{
      background:#fee2e2;
      color:#991b1b;
      padding:15px 20px;
      border-radius:12px;
      margin-bottom:25px;
    }

    /* TOPBAR */
    .topbar{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:40px;
    }

    .topbar h1{
      font-size:38px;
      color:#111827;
    }

    .topbar p{
      color:#6b7280;
      margin-top:8px;
    }

    .profile{
      display:flex;
      align-items:center;
      gap:15px;
    }

    .profile img{
      width:50px;
      height:50px;
      border-radius:50%;
      object-fit:cover;
    }

    /* FORM CONTAINER */
    .form-container{
      background:white;
      padding:40px;
      border-radius:25px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .form-grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:25px;
    }

    .input-group{
      display:flex;
      flex-direction:column;
    }

    .input-group label{
      margin-bottom:10px;
      font-weight:bold;
      color:#374151;
    }

    .input-group input,
    .input-group textarea,
    .input-group select{
      padding:15px;
      border:1px solid #d1d5db;
      border-radius:12px;
      font-size:16px;
    }

    .input-group textarea{
      resize:none;
      height:130px;
    }

    .input-group input:focus,
    .input-group textarea:focus,
    .input-group select:focus{
      border-color:#2563eb;
      outline:none;
    }

    .full-width{
      grid-column:1/3;
    }

    /* IMAGE UPLOAD */
    .upload-box{
      border:2px dashed #cbd5e1;
      border-radius:15px;
      padding:40px;
      text-align:center;
      cursor:pointer;
      transition:0.3s;
      background:#f8fafc;
    }

    .upload-box:hover{
      background:#eff6ff;
      border-color:#2563eb;
    }

    .upload-box p{
      color:#6b7280;
      margin-top:10px;
    }

    /* BUTTONS */
    .btn-group{
      margin-top:35px;
      display:flex;
      gap:20px;
    }

    .create-btn{
      background:#2563eb;
      color:white;
      border:none;
      padding:16px 28px;
      border-radius:12px;
      font-size:17px;
      font-weight:bold;
      cursor:pointer;
      transition:0.3s;
    }

    .create-btn:hover{
      background:#1d4ed8;
    }

    .cancel-btn{
      background:#e5e7eb;
      color:#111827;
      border:none;
      padding:16px 28px;
      border-radius:12px;
      font-size:17px;
      font-weight:bold;
      cursor:pointer;
      text-decoration:none;
      display:inline-block;
      text-align:center;
    }

    /* QUICK TIPS */
    .tips{
      margin-top:40px;
      background:#eff6ff;
      border-left:6px solid #2563eb;
      padding:25px;
      border-radius:15px;
    }

    .tips h3{
      margin-bottom:15px;
      color:#1e3a8a;
    }

    .tips ul{
      padding-left:20px;
      color:#374151;
      line-height:1.8;
    }

    /* RESPONSIVE */
    @media(max-width:900px){
      .sidebar{
        display:none;
      }
      .main{
        margin-left:0;
        width:100%;
        padding:20px;
      }
      .form-grid{
        grid-template-columns:1fr;
      }
      .full-width{
        grid-column:1/2;
      }
      .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
      }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo">
      Traveloop
    </div>

    <ul class="menu">
      <li><a href="{{ url('/dashboard') }}">🏠 Dashboard</a></li>
      <li><a href="{{ url('/create-trip') }}">✈ Create Trip</a></li>
      <li><a href="{{ url('/my-trips') }}">🧳 My Trips</a></li>
      <li><a href="{{ url('/itinerary') }}">📅 Build Itinerary</a></li>
      <li><a href="{{ url('/itinerary-view') }}">🗺 Itinerary View</a></li>
      <li><a href="{{ url('/search') }}">🌍 City Search</a></li>
      <li><a href="{{ url('/activity-search') }}">🎯 Activity Search</a></li>
      <li><a href="{{ url('/budget') }}">💰 Budget Planner</a></li>
      <li><a href="{{ url('/packing') }}">🎒 Packing Checklist</a></li>
      <li><a href="{{ url('/community-trips') }}">🌐 Community Trips</a></li>
      <li><a href="{{ url('/trip-notes') }}">📝 Trip Notes</a></li>
      <li><a href="{{ url('/profile') }}">👤 Profile & Settings</a></li>
      <li><a href="{{ url('/admin') }}">📊 Admin Analytics</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
          @csrf
          <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Logout</a>
        </form>
      </li>
    </ul>
  </div>

  <!-- MAIN -->
  <div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
      <div>
        <h1>Create New Trip ✈</h1>
        <p>Start planning your next unforgettable journey</p>
      </div>

      <div class="profile">
        <img 
          src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/150?img=12' }}"
          alt="Profile Photo"
        >
      </div>
    </div>

    <!-- VALIDATION ERRORS -->
    @if ($errors->any())
      <div class="alert-error">
        <strong>Whoops! Something went wrong.</strong>
        <ul style="margin-left: 20px; margin-top: 10px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- FORM -->
    <div class="form-container">
      <form action="{{ url('/trips/create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid">

          <!-- TRIP NAME -->
          <div class="input-group">
            <label>Trip Name <span style="color:red;">*</span></label>
            <input type="text" name="name" placeholder="Enter trip name" value="{{ old('name') }}" required>
          </div>

          <!-- DESTINATION -->
          <div class="input-group">
            <label>Main Destination</label>
            <input type="text" name="destination" placeholder="Enter destination" value="{{ old('destination') }}">
          </div>

          <!-- START DATE -->
          <div class="input-group">
            <label>Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}">
          </div>

          <!-- END DATE -->
          <div class="input-group">
            <label>End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}">
          </div>

          <!-- TRAVELERS -->
          <div class="input-group">
            <label>Travelers</label>
            <select name="travelers">
              <option value="1" {{ old('travelers') == '1' ? 'selected' : '' }}>1 Person</option>
              <option value="2" {{ old('travelers') == '2' ? 'selected' : '' }}>2 People</option>
              <option value="3" {{ old('travelers') == '3' ? 'selected' : '' }}>3 People</option>
              <option value="4" {{ old('travelers') == '4' ? 'selected' : '' }}>4+ People</option>
            </select>
          </div>

          <!-- BUDGET -->
          <div class="input-group">
            <label>Estimated Budget</label>
            <input type="number" name="budget" placeholder="Enter estimated budget" value="{{ old('budget') }}" step="0.01">
          </div>

          <!-- DESCRIPTION -->
          <div class="input-group full-width">
            <label>Trip Description</label>
            <textarea name="description" placeholder="Describe your trip plan, activities, goals, and travel preferences...">{{ old('description') }}</textarea>
          </div>

          <!-- COVER PHOTO -->
          <div class="input-group full-width">
            <label>Upload Cover Photo</label>
            <div class="upload-box" onclick="document.getElementById('cover_photo').click()">
              <h2>📷 Upload Travel Image</h2>
              <p>Drag & Drop or Click to Upload</p>
              <input type="file" id="cover_photo" name="cover_photo" accept="image/*" style="margin-top:20px; display: none;">
              <p id="file-name-display" style="font-weight: bold; margin-top: 15px;"></p>
            </div>
          </div>

        </div>

        <!-- BUTTONS -->
        <div class="btn-group">
          <button type="submit" class="create-btn">Create Trip</button>
          <a href="{{ url('/my-trips') }}" class="cancel-btn">Cancel</a>
        </div>
      </form>
    </div>

    <!-- TIPS -->
    <div class="tips">
      <h3>💡 Travel Planning Tips</h3>
      <ul>
        <li>Plan your destinations according to weather and season.</li>
        <li>Set a realistic travel budget including hotels and transport.</li>
        <li>Keep emergency funds for unexpected situations.</li>
        <li>Add activities and sightseeing plans early for better organization.</li>
      </ul>
    </div>
  </div>

  <!-- JAVASCRIPT -->
  <script>
    // Display selected file name in the upload box
    document.getElementById('cover_photo').addEventListener('change', function() {
      const fileName = this.files[0] ? this.files[0].name : '';
      document.getElementById('file-name-display').textContent = fileName;
    });
  </script>
</body>
</html>