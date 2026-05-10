<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Trips - Traveloop</title>

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
      color:#6b7280;
      margin-top:8px;
    }

    .topbar button{
      background:#2563eb;
      color:white;
      border:none;
      padding:15px 25px;
      border-radius:12px;
      font-size:16px;
      font-weight:bold;
      cursor:pointer;
    }

    .filters{
      display:flex;
      gap:20px;
      margin-bottom:30px;
      flex-wrap:wrap;
    }

    .filters input,
    .filters select{
      padding:14px;
      border:1px solid #d1d5db;
      border-radius:12px;
      font-size:15px;
      min-width:220px;
    }

    .trip-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(330px,1fr));
      gap:30px;
    }

    .trip-card{
      background:white;
      border-radius:25px;
      overflow:hidden;
      box-shadow:0 8px 20px rgba(0,0,0,0.08);
      transition:0.3s;
    }

    .trip-card:hover{
      transform:translateY(-6px);
    }

    .trip-image{
      position:relative;
    }

    .trip-image img{
      width:100%;
      height:240px;
      object-fit:cover;
    }

    .trip-status{
      position:absolute;
      top:15px;
      right:15px;
      background:#059669;
      color:white;
      padding:8px 14px;
      border-radius:20px;
      font-size:13px;
      font-weight:bold;
    }

    .trip-content{
      padding:25px;
    }

    .trip-content h2{
      color:#111827;
      margin-bottom:10px;
    }

    .trip-content p{
      color:#6b7280;
      line-height:1.7;
      margin-bottom:20px;
    }

    .trip-info{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:15px;
      margin-bottom:25px;
    }

    .info-box{
      background:#eff6ff;
      padding:15px;
      border-radius:12px;
    }

    .info-box h4{
      color:#2563eb;
      margin-bottom:5px;
      font-size:14px;
    }

    .info-box span{
      font-weight:bold;
      color:#111827;
    }

    .btn-group{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
    }

    .btn{
      flex:1;
      border:none;
      padding:12px;
      border-radius:10px;
      cursor:pointer;
      font-weight:bold;
    }

    .view-btn{
      background:#2563eb;
      color:white;
    }

    .edit-btn{
      background:#f59e0b;
      color:white;
    }

    .delete-btn{
      background:#ef4444;
      color:white;
    }

    .empty{
      background:white;
      padding:50px;
      text-align:center;
      border-radius:20px;
      margin-top:40px;
      display:none;
    }

    @media(max-width:900px){

      .sidebar{
        display:none;
      }

      .main{
        margin-left:0;
        width:100%;
        padding:20px;
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

      <h1>My Trips ✈</h1>

      <p>
        Manage and explore all your travel plans
      </p>

    </div>

    <button onclick="createTrip()">
      + Create New Trip
    </button>

  </div>

  <div class="filters">

    <input
      type="text"
      placeholder="Search trips..."
    >

    <select>
      <option>All Trips</option>
      <option>Upcoming</option>
      <option>Completed</option>
      <option>Cancelled</option>
    </select>

    <select>
      <option>Sort By</option>
      <option>Newest</option>
      <option>Oldest</option>
      <option>Budget</option>
    </select>

  </div>

  <div class="trip-grid">

    @foreach($trips as $trip)

    <div class="trip-card">

      <div class="trip-image">

        <img src="{{ $trip['image'] }}">

        <div class="trip-status">
          {{ $trip['status'] }}
        </div>

      </div>

      <div class="trip-content">

        <h2>
          {{ $trip['title'] }}
        </h2>

        <p>
          {{ $trip['description'] }}
        </p>

        <div class="trip-info">

          <div class="info-box">

            <h4>Duration</h4>

            <span>
              {{ $trip['duration'] }}
            </span>

          </div>

          <div class="info-box">

            <h4>Budget</h4>

            <span>
              ${{ $trip['budget'] }}
            </span>

          </div>

          <div class="info-box">

            <h4>Travelers</h4>

            <span>
              {{ $trip['travelers'] }}
            </span>

          </div>

          <div class="info-box">

            <h4>Stops</h4>

            <span>
              {{ $trip['stops'] }}
            </span>

          </div>

        </div>

        <div class="btn-group">

          <button class="btn view-btn">
            View
          </button>

          <button class="btn edit-btn">
            Edit
          </button>

          <button
            class="btn delete-btn"
            onclick="deleteTrip(this)"
          >
            Delete
          </button>

        </div>

      </div>

    </div>

    @endforeach

  </div>

  <div class="empty" id="emptyState">

    <h2>No Trips Available</h2>

    <p>
      Start planning your next adventure now.
    </p>

    <button>
      Create Trip
    </button>

  </div>

</div>

<script>

  function createTrip(){

    window.location.href = "/create-trip";

  }

  function deleteTrip(button){

    const card = button.closest(".trip-card");

    card.remove();

    checkEmpty();

  }

  function checkEmpty(){

    const cards =
    document.querySelectorAll(".trip-card");

    if(cards.length === 0){

      document
      .getElementById("emptyState")
      .style.display = "block";
    }

  }

</script>

</body>
</html>