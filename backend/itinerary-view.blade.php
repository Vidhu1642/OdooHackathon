<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Itinerary View - Traveloop</title>

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
      margin-top:8px;
      color:#6b7280;
    }

    .top-buttons{
      display:flex;
      gap:15px;
    }

    .btn{
      border:none;
      padding:14px 22px;
      border-radius:12px;
      font-size:15px;
      font-weight:bold;
      cursor:pointer;
    }

    .share-btn{
      background:#2563eb;
      color:white;
    }

    .pdf-btn{
      background:#059669;
      color:white;
    }

    .overview{
      background:white;
      border-radius:25px;
      overflow:hidden;
      margin-bottom:35px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .overview img{
      width:100%;
      height:350px;
      object-fit:cover;
    }

    .overview-content{
      padding:30px;
    }

    .overview-content h2{
      font-size:32px;
      color:#111827;
      margin-bottom:15px;
    }

    .overview-content p{
      color:#6b7280;
      line-height:1.8;
    }

    .stats{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
      gap:20px;
      margin-top:30px;
    }

    .stat-card{
      background:#eff6ff;
      padding:20px;
      border-radius:15px;
    }

    .stat-card h3{
      color:#2563eb;
      margin-bottom:10px;
    }

    .stat-card span{
      font-size:22px;
      font-weight:bold;
      color:#111827;
    }

    .timeline-section{
      margin-top:40px;
    }

    .section-title{
      font-size:32px;
      color:#111827;
      margin-bottom:30px;
    }

    .timeline{
      position:relative;
      padding-left:40px;
    }

    .timeline::before{
      content:'';
      position:absolute;
      left:12px;
      top:0;
      width:4px;
      height:100%;
      background:#2563eb;
    }

    .timeline-card{
      position:relative;
      background:white;
      border-radius:20px;
      padding:25px;
      margin-bottom:30px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .timeline-card::before{
      content:'';
      position:absolute;
      left:-36px;
      top:35px;
      width:22px;
      height:22px;
      border-radius:50%;
      background:#2563eb;
      border:5px solid #dbeafe;
    }

    .timeline-header{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:20px;
      flex-wrap:wrap;
      gap:15px;
    }

    .timeline-header h2{
      color:#111827;
    }

    .timeline-header span{
      background:#dbeafe;
      color:#2563eb;
      padding:10px 16px;
      border-radius:20px;
      font-weight:bold;
    }

    .activity{
      background:#f9fafb;
      padding:18px;
      border-radius:15px;
      margin-bottom:15px;
    }

    .activity h3{
      color:#2563eb;
      margin-bottom:10px;
    }

    .activity p{
      color:#6b7280;
      margin-bottom:10px;
      line-height:1.6;
    }

    .activity-info{
      display:flex;
      justify-content:space-between;
      align-items:center;
      flex-wrap:wrap;
      gap:10px;
    }

    .cost{
      color:#059669;
      font-weight:bold;
    }

    .map-section{
      margin-top:40px;
      background:white;
      padding:25px;
      border-radius:20px;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
    }

    .map-section h2{
      margin-bottom:20px;
      color:#111827;
    }

    .map-placeholder{
      height:350px;
      border-radius:20px;
      overflow:hidden;
    }

    .map-placeholder img{
      width:100%;
      height:100%;
      object-fit:cover;
    }

    @media(max-width:1000px){

      .sidebar{
        display:none;
      }

      .main{
        margin-left:0;
        width:100%;
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

      <h1>Trip Itinerary 📅</h1>

      <p>
        Review your complete travel journey
      </p>

    </div>

    <div class="top-buttons">

      <button class="btn share-btn"
        onclick="shareTrip()">

        Share Trip

      </button>

      <button class="btn pdf-btn"
        onclick="downloadPDF()">

        Download PDF

      </button>

    </div>

  </div>

  <div class="overview">

    <img src="{{ $trip['image'] }}">

    <div class="overview-content">

      <h2>{{ $trip['title'] }}</h2>

      <p>
        {{ $trip['description'] }}
      </p>

      <div class="stats">

        <div class="stat-card">

          <h3>Total Days</h3>

          <span>{{ $trip['days'] }} Days</span>

        </div>

        <div class="stat-card">

          <h3>Cities</h3>

          <span>{{ $trip['cities'] }} Stops</span>

        </div>

        <div class="stat-card">

          <h3>Activities</h3>

          <span>{{ $trip['activities'] }} Activities</span>

        </div>

        <div class="stat-card">

          <h3>Budget</h3>

          <span>${{ $trip['budget'] }}</span>

        </div>

      </div>

    </div>

  </div>

  <div class="timeline-section">

    <h2 class="section-title">
      Travel Timeline
    </h2>

    <div class="timeline">

      @foreach($timeline as $day)

      <div class="timeline-card">

        <div class="timeline-header">

          <h2>
            {{ $day['day'] }}
          </h2>

          <span>
            {{ $day['date'] }}
          </span>

        </div>

        @foreach($day['activities'] as $activity)

        <div class="activity">

          <h3>
            {{ $activity['title'] }}
          </h3>

          <p>
            {{ $activity['description'] }}
          </p>

          <div class="activity-info">

            <span>
              ⏰ {{ $activity['duration'] }}
            </span>

            <span class="cost">
              ${{ $activity['cost'] }}
            </span>

          </div>

        </div>

        @endforeach

      </div>

      @endforeach

    </div>

  </div>

  <div class="map-section">

    <h2>Trip Route Map 🌍</h2>

    <div class="map-placeholder">

      <img src="{{ $trip['map_image'] }}">

    </div>

  </div>

</div>

<script>

  function shareTrip(){

    alert(
      "Trip Share Link Generated!"
    );

  }

  function downloadPDF(){

    alert(
      "Downloading Itinerary PDF..."
    );

  }

</script>

</body>
</html>