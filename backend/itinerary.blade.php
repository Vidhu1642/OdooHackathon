<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Itinerary Builder - Traveloop</title>

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

    .main{
      margin-left:260px;
      width:calc(100% - 260px);
      padding:40px;
    }

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

    .save-btn{
      background:#2563eb;
      color:white;
      border:none;
      padding:15px 25px;
      border-radius:12px;
      font-size:16px;
      font-weight:bold;
      cursor:pointer;
    }

    .save-btn:hover{
      background:#1d4ed8;
    }

    .builder-container{
      display:grid;
      grid-template-columns:2fr 1fr;
      gap:30px;
    }

    .left-panel{
      display:flex;
      flex-direction:column;
      gap:25px;
    }

    .city-card{
      background:white;
      border-radius:20px;
      padding:25px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .city-header{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:20px;
    }

    .city-header h2{
      color:#111827;
    }

    .city-header button{
      background:#ef4444;
      color:white;
      border:none;
      padding:10px 18px;
      border-radius:10px;
      cursor:pointer;
    }

    .date-row{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:20px;
      margin-bottom:25px;
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

    .input-group input{
      padding:14px;
      border:1px solid #d1d5db;
      border-radius:10px;
    }

    .activity-section{
      margin-top:10px;
    }

    .activity-title{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:20px;
    }

    .activity-title h3{
      color:#111827;
    }

    .add-activity-btn{
      background:#059669;
      color:white;
      border:none;
      padding:10px 18px;
      border-radius:10px;
      cursor:pointer;
    }

    .activity-card{
      background:#eff6ff;
      padding:18px;
      border-radius:15px;
      margin-bottom:15px;
    }

    .activity-card h4{
      margin-bottom:8px;
      color:#2563eb;
    }

    .activity-card p{
      color:#4b5563;
      margin-bottom:10px;
    }

    .activity-info{
      display:flex;
      justify-content:space-between;
      align-items:center;
    }

    .activity-cost{
      color:#059669;
      font-weight:bold;
    }

    .add-stop{
      background:white;
      border:2px dashed #cbd5e1;
      border-radius:20px;
      padding:30px;
      text-align:center;
      cursor:pointer;
      transition:0.3s;
    }

    .add-stop:hover{
      background:#eff6ff;
      border-color:#2563eb;
    }

    .add-stop h2{
      color:#2563eb;
    }

    .right-panel{
      display:flex;
      flex-direction:column;
      gap:25px;
    }

    .summary-card{
      background:white;
      padding:25px;
      border-radius:20px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .summary-card h2{
      margin-bottom:20px;
      color:#111827;
    }

    .summary-item{
      display:flex;
      justify-content:space-between;
      margin-bottom:15px;
      color:#4b5563;
    }

    .summary-total{
      margin-top:20px;
      padding-top:15px;
      border-top:1px solid #d1d5db;
      display:flex;
      justify-content:space-between;
      font-size:20px;
      font-weight:bold;
      color:#111827;
    }

    .timeline{
      background:white;
      padding:25px;
      border-radius:20px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .timeline h2{
      margin-bottom:20px;
    }

    .timeline-item{
      padding:15px;
      border-left:4px solid #2563eb;
      margin-bottom:20px;
      background:#f9fafb;
      border-radius:10px;
    }

    .timeline-item h4{
      color:#2563eb;
      margin-bottom:8px;
    }

    .timeline-item p{
      color:#6b7280;
    }

    @media(max-width:1000px){

      .sidebar{
        display:none;
      }

      .main{
        margin-left:0;
        width:100%;
      }

      .builder-container{
        grid-template-columns:1fr;
      }

      .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
      }

      .date-row{
        grid-template-columns:1fr;
      }

    }

  </style>
</head>

<body>

<div class="sidebar">

  <div class="logo">
    Traveloop
  </div>

  <ul class="menu">

    <li><a href="{{ url('/dashboard') }}">🏠 Dashboard</a></li>

    <li><a href="{{ url('/create-trip') }}">✈ Create Trip</a></li>

    <li><a href="{{ url('/my-trip') }}">🧳 My Trips</a></li>

    <li><a href="{{ url('/itinerary') }}">📅 Build Itinerary</a></li>

    <li><a href="{{ url('/itinerary-view') }}">🗺 Itinerary View</a></li>

    <li><a href="{{ url('/search') }}">🌍 City Search</a></li>

    <li><a href="{{ url('/activity-search') }}">🎯 Activity Search</a></li>

    <li><a href="{{ url('/budget-cost') }}">💰 Budget Planner</a></li>

    <li><a href="{{ url('/packing') }}">🎒 Packing Checklist</a></li>

    <li><a href="{{ url('/public-itinerary') }}">🌐 Community Trips</a></li>

    <li><a href="{{ url('/trip-notes') }}">📝 Trip Notes</a></li>

    <li><a href="{{ url('/profile') }}">👤 Profile & Settings</a></li>

    <li><a href="{{ url('/admin-dashboard') }}">📊 Admin Analytics</a></li>

    <li><a href="{{ url('/') }}">🚪 Logout</a></li>

  </ul>

</div>

<div class="main">

  <div class="topbar">

    <div>

      <h1>Itinerary Builder 📅</h1>

      <p>
        Organize cities, travel dates, and activities
      </p>

    </div>

    <button class="save-btn" onclick="saveItinerary()">
      Save Itinerary
    </button>

  </div>

  <div class="builder-container">

    <div class="left-panel">

      @foreach($cities as $city)

      <div class="city-card">

        <div class="city-header">

          <h2>
            📍 {{ $city['name'] }}
          </h2>

          <button>
            Remove
          </button>

        </div>

        <div class="date-row">

          <div class="input-group">

            <label>Arrival Date</label>

            <input
              type="date"
              value="{{ $city['arrival'] }}"
            >

          </div>

          <div class="input-group">

            <label>Departure Date</label>

            <input
              type="date"
              value="{{ $city['departure'] }}"
            >

          </div>

        </div>

        <div class="activity-section">

          <div class="activity-title">

            <h3>Activities</h3>

            <button class="add-activity-btn">
              + Add Activity
            </button>

          </div>

          @foreach($city['activities'] as $activity)

          <div class="activity-card">

            <h4>
              {{ $activity['title'] }}
            </h4>

            <p>
              {{ $activity['description'] }}
            </p>

            <div class="activity-info">

              <span>
                ⏰ {{ $activity['duration'] }}
              </span>

              <span class="activity-cost">
                ${{ $activity['cost'] }}
              </span>

            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endforeach

      <div class="add-stop" onclick="addStop()">

        <h2>+ Add New Stop</h2>

        <p style="margin-top:10px;color:#6b7280;">
          Add another city to your itinerary
        </p>

      </div>

    </div>

    <div class="right-panel">

      <div class="summary-card">

        <h2>Trip Summary</h2>

        <div class="summary-item">
          <span>Total Cities</span>
          <strong>{{ count($cities) }}</strong>
        </div>

        <div class="summary-item">
          <span>Total Activities</span>
          <strong>{{ $totalActivities }}</strong>
        </div>

        <div class="summary-item">
          <span>Total Days</span>
          <strong>{{ $totalDays }} Days</strong>
        </div>

        <div class="summary-item">
          <span>Estimated Budget</span>
          <strong>${{ $totalBudget }}</strong>
        </div>

        <div class="summary-total">

          <span>Total Cost</span>

          <span>${{ $totalBudget }}</span>

        </div>

      </div>

    </div>

  </div>

</div>

<script>

  function saveItinerary(){

    alert("Itinerary Saved Successfully!");

  }

  function addStop(){

    alert("Add Stop Feature Clicked!");

  }

</script>

</body>
</html>