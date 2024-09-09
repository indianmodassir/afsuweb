<?php
  function unavailable($type) {
    return "<style>
      .unavailable {
        font-size: 15px;
        max-width: 600px;
        margin: 6% auto 22px auto;
        border: 1px solid #ccc;
      }
      .content {
        padding: 11px;
      }
      a {
        font-size: 14px;
        font-family: inherit;
      }
      a:hover {
        text-decoration: underline;
      }
      .topbar {
        text-transform: uppercase;
        text-align: center;
        color: #fff;
        padding: 11px;
        background-color: #fb3b3b;
      }
    </style>
    <div class=\"unavailable\">
      <div class=\"main\">
        <div class=\"topbar\">
          <h2>Unavailable {$type} Servey</h2>
          <div style=\"font-size:12px;font-weight:500;\">This servery are temporarily unavailable, Please try of the moment.</div>
        </div>
        <div class=\"content\">
          <strong>Notice:</strong>
          <ul style=\"padding-top:0;padding-bottom:0;list-style-type:square;margin-left:11px;\">
            <li>This servey will be available soon after conducted (ASOT) Intermediate Test. User can't be check result and Download answer-key before given test or Unregistered user.</li>
            <li>If do you want to exit and goto Homepage from this page click <a href=\"/\">Goto Homepage</a></li>
          </ul>
        </div>
      </div>
    </div>";
  }
?>