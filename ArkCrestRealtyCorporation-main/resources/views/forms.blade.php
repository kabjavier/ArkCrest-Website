@extends('layouts.dashboard')
@section('title', 'Forms')
@section('content')
<style>
.frm-wrap{padding:24px 30px;max-width:816px;margin:0 auto}
.btn-clear-f{padding:10px 24px;background:#f3f4f6;color:#374151;border:2px solid #d0d5dd;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer}
.btn-print-f{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#1e4575;color:white;border:none;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer}
.btn-submit-f{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:linear-gradient(135deg,#1e4575 0%,#2563eb 60%,#1e4575 100%);background-size:200% auto;color:white;border:none;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;transition:all .2s}
.btn-submit-f:disabled{opacity:.55;cursor:not-allowed}
.frm-card{background:white;padding:32px 48px 32px 48px;border:1px solid #ccc;font-family:Arial,sans-serif;color:#000;width:816px;box-sizing:border-box;margin:0 auto;}
.frm-hdr{display:flex;align-items:center;justify-content:flex-start;gap:16px;margin-bottom:4px}
.frm-logo{width:80px;height:80px;flex-shrink:0;}
.frm-logo img{width:100%;height:100%;object-fit:contain}
.frm-title-block .dept{font-size:20px;font-weight:900;text-decoration:underline;color:#000;letter-spacing:.3px}
.frm-title-block .form-name{font-size:14px;font-weight:700;color:#1e3a8a;margin-top:2px}
.ctrl-num{text-align:center;font-size:13px;font-weight:700;color:#dc2626;margin:8px 0 10px;letter-spacing:.5px}
.info-tbl{width:100%;border-collapse:collapse;font-size:12px;margin-bottom:0}
.info-tbl td{border:1px solid #000;padding:5px 7px}
.info-tbl td.lbl{font-weight:700;white-space:nowrap;background:#fafafa;width:1%}
.info-tbl input,.info-tbl select{width:100%;border:none;outline:none;font-size:12px;font-family:Arial,sans-serif;background:transparent;padding:0}
.info-tbl input[readonly]{color:#374151}
.frm-note{font-size:11px;color:#dc2626;margin:4px 0 4px;line-height:1.5}
.frm-divider{border:none;border-top:1.5px solid #333;margin:10px 0}
.liq-hdr{text-align:center;font-size:15px;font-weight:700;color:#1e3a8a;margin:0 0 6px;letter-spacing:.5px}
.liq-tbl{width:100%;border-collapse:collapse;font-size:11px}
.liq-tbl th,.liq-tbl td{border:1px solid #000;padding:1px 4px;text-align:center;height:20px;}
.liq-tbl th{background:#f0f0f0;font-weight:700;font-size:11px}
.liq-tbl td.amt{text-align:left;padding-left:5px}
.cert{font-size:11px;margin:8px 0 10px;line-height:1.4}
.sigs{width:100%;border-collapse:collapse;font-size:11px;margin-top:0}
.sigs td{border:1px solid #000;padding:4px 8px;vertical-align:top;width:33.33%}
.sig-space{height:30px}
.dept-sel{font-size:12px;color:#555;margin-top:10px}
.dept-sel select{font-size:12px;padding:2px 6px;border:1px solid #ccc;border-radius:4px}
.frm-btns{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
.frm-alert{font-size:12px;padding:9px 14px;border-radius:8px;border-left:3px solid;margin:10px 0;line-height:1.5;display:none}
.frm-alert.show{display:block}
.frm-alert-success{background:#f0fdf4;border-color:#22c55e;color:#16a34a}
.frm-alert-error{background:#fef2f2;border-color:#ef4444;color:#dc2626}
.frm-alert-warn{background:#fff7ed;border-color:#f97316;color:#9a3412}

/* Wrapper used to auto-scale the fixed-width (816px) printable card
   down to fit small screens, without changing its internal layout
   or affecting the print/PDF output quality. See fitCardToWidth() JS. */
.frm-scale-wrap{width:100%;overflow:visible;}

/* ============================================================
   MOBILE RESPONSIVE (tablet & phone)
   ============================================================ */
@media (max-width:860px){
  .frm-wrap{padding:16px 10px}
  .frm-btns{flex-wrap:wrap}
  .frm-btns button{flex:1 1 auto;justify-content:center;min-height:46px;font-size:14px}
  .modal-bar{flex-wrap:wrap;gap:10px;padding:14px 16px!important}
  .modal-bar > div:last-child{flex-wrap:wrap;width:100%;justify-content:flex-end}
  .modal-bar > div:last-child button{min-height:40px}
  .modal-body-pad{padding:12px!important}
  .frm-preview-modal{padding:0!important}
}
@media (max-width:480px){
  .frm-wrap{padding:12px 6px}
}

@media print{
  body *{visibility:hidden}
  #frmPreviewModal, #frmPreviewModal *{visibility:visible}
  #frmPreviewModal{position:fixed;inset:0;background:#fff;padding:0;margin:0;display:flex!important;align-items:flex-start;justify-content:center;overflow:visible;}
  #frmPreviewModal .modal-bar{display:none!important}
  #frmPreviewBody{box-shadow:none!important;width:auto!important;height:auto!important;background:transparent!important;padding:0!important}
  #frmPreviewBody .frm-card{
    position:static;
    width:100%;max-width:8.5in;
    padding:0.35in 0.45in;
    border:none;
    box-shadow:none;
    font-size:11px;
    margin:0 auto;
    transform:none!important;
  }
  .dept-sel,.frm-btns{display:none!important}
  @page{size:8.5in 11in;margin:0}
}
</style>

<div class="frm-wrap">

  {{-- ============================= --}}
  {{-- Budget Request Form Tab       --}}
  {{-- ============================= --}}
  <div id="tab-budget">
  <div class="frm-scale-wrap" id="frmCardWrap">
  <div class="frm-card" id="frmCard">

    <!-- Header -->
    <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:6px;">
      <div style="display:flex;align-items:center;gap:14px;justify-content:center;">
        <img src="{{ asset('images/ArkCrest_Logo.png') }}" alt="Logo" style="width:80px;height:80px;object-fit:contain;flex-shrink:0;">
        <div style="text-align:center;">
          <div id="disp_dept" style="font-size:24px;font-weight:700;text-decoration:underline;color:#000;text-transform:uppercase;letter-spacing:.5px;">HUMAN RESOURCES DEPARTMENT</div>
          <div style="font-size:24px;font-weight:700;color:#2563eb;margin-top:10px;letter-spacing:.5px;">BUDGET REQUEST FORM</div>
          <div class="dept-sel" style="margin-top:6px;">
            <select id="f_dept" onchange="updDept()" style="font-size:12px;padding:3px 8px;border:1px solid #ccc;border-radius:4px;">
              @foreach($departments->where('slug', '!=', 'capex') as $dept)
              <option value="{{ strtoupper($dept->name) }}">{{ $dept->name }} Department</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <div style="text-align:right;font-size:16px;font-weight:700;color:#dc2626;margin-bottom:4px;margin-top:10px;letter-spacing:.3px;">Control Number: <span id="ctrlNumDisplay">Loading...</span></div>
    <table class="info-tbl">
      <tr>
        <td class="lbl">Name:</td>
        <td><input type="text" id="f_name" autocomplete="off" onblur="addToNameList(this.value)" oninput="showNameSuggestions(this.value)" style="width:100%;border:none;outline:none;font-size:12px;font-family:Arial,sans-serif;background:transparent;padding:0">
        <div id="nameSuggestBox" style="display:none;position:absolute;background:white;border:1px solid #ccc;border-radius:4px;z-index:9999;min-width:200px;max-height:150px;overflow-y:auto;box-shadow:0 2px 8px rgba(0,0,0,.15);font-size:12px;font-family:Arial,sans-serif;"></div></td>
        <td class="lbl">Date Requested:</td>
        <td><input type="date" id="f_date_req"></td>
      </tr>
      <tr>
        <td class="lbl">Amount Requested: &#8369;</td>
        <td><input type="number" id="f_amount" placeholder="0.00" step="0.01" min="0"></td>
        <td class="lbl">Target Date Released:</td>
        <td><input type="date" id="f_target"></td>
      </tr>
      <tr>
        <td class="lbl">Particular :</td>
        <td>
          <input type="text" id="f_cat" list="f_cat_list" placeholder="Select or type..." autocomplete="off"
            style="width:100%;border:none;outline:none;font-size:12px;font-family:Arial,sans-serif;background:transparent;padding:0">
          <datalist id="f_cat_list"></datalist>
        </td>
        <td class="lbl">Remarks:</td>
        <td><input type="text" id="f_remarks"></td>
      </tr>
    </table>

    <!-- Note -->
    <div class="frm-note">
      <strong>Note:</strong> (a) For amount less than <strong>&#8369;1,000.00</strong> disbursement will be processed with in the day<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) Amount of <strong>&#8369;1,000.00</strong> or more than will be disbursed at least one week after the submission.
    </div>

    <!-- Liquidation Report -->
    <hr style="border:none;border-top:1.5px solid #000;margin:10px 0 8px 0;">
    <p class="liq-hdr" style="color:#2563eb;font-weight:700;font-size:20px;text-align:center;margin:0 0 8px 0;letter-spacing:.5px;">LIQUIDATION REPORT</p>
    <table class="liq-tbl">
      <thead>
        <tr>
          <th style="width:13%">DATE</th>
          <th style="width:20%">RECEIPT / INVOICE NO.</th>
          <th style="width:47%">PARTICULARS</th>
          <th style="width:20%">AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        @for($i=0;$i<25;$i++)
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td><input type="text" style="width:100%;border:none;outline:none;font-size:11px;font-family:Arial,sans-serif;background:transparent;padding:0;"></td>
          <td class="amt">&#8369;</td>
        </tr>
        @endfor
      </tbody>
    </table>
    <table style="width:100%;border-collapse:collapse;font-size:11px;font-weight:700;margin-top:10px;">
      <tr>
        <td style="border:1px solid #000;padding:5px 7px;width:50%;">TOTAL EXPENSES: &#8369; _______________</td>
        <td style="border:1px solid #000;padding:5px 7px;width:50%;">LESS CASH ADVANCE: &#8369; _______________</td>
      </tr>
      <tr>
        <td colspan="2" style="border:1px solid #000;padding:5px 7px;">AMOUNT TO BE RETURNED: &#8369; _______________</td>
      </tr>
    </table>

    <!-- Certification -->
    <p style="font-size:11px;font-weight:700;margin:6px 0 8px 0;padding:0;line-height:1.4;">This is to certify that the foregoing expenses were disbursed in conformity with the above stated purpose(s).</p>

    <!-- Signatures -->
    <table class="sigs">
      <tr>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Checked &amp; Approved by:</td>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Released by:</td>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Received by:</td>
      </tr>
      <tr>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;font-weight:700;">
          <input type="text" id="f_approved_by" style="border:none;outline:none;font-size:11px;font-weight:700;font-family:Arial,sans-serif;background:transparent;width:100%;padding:0;text-align:center;text-transform:uppercase;" placeholder="NAME">
        </td>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;"></td>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;"></td>
      </tr>
      <tr>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
      </tr>
    </table>

    <!-- Buttons (screen only) -->
    <div class="frm-btns dept-sel">
      <button class="btn-clear-f" onclick="clearForm()">Clear</button>
      <button class="btn-print-f" onclick="openPreview('frmCard','Budget Request Form')">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print Budget Request Form
      </button>
    </div>

  </div>
</div>

  </div>{{-- #tab-budget --}}

  {{-- ============================= --}}
  {{-- Site Visit Form Tab           --}}
  {{-- ============================= --}}
  <div id="tab-sitevisit" style="display:none">
  <div class="frm-scale-wrap" id="frmCardSVWrap">
  <div class="frm-card" id="frmCardSV">

    <!-- Header -->
    <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:6px;">
      <div style="display:flex;align-items:center;gap:14px;justify-content:center;">
        <img src="{{ asset('images/ArkCrest_Logo.png') }}" alt="Logo" style="width:80px;height:80px;object-fit:contain;flex-shrink:0;">
        <div style="text-align:center;">
          <div style="font-size:24px;font-weight:700;text-decoration:underline;color:#000;text-transform:uppercase;letter-spacing:.5px;">ARKCREST REALTY CORPORATION</div>
          <div style="font-size:24px;font-weight:700;color:#2563eb;margin-top:10px;letter-spacing:.5px;">SITE VISIT FORM</div>
        </div>
      </div>
    </div>
    <div style="text-align:right;font-size:16px;font-weight:700;margin-bottom:4px;margin-top:10px;letter-spacing:.3px;">
      Status: <span id="svStatusDisplay" style="color:#dc2626;">Not Yet Submitted</span>
    </div>

    <table class="info-tbl">
      <tr>
        <td class="lbl">Agent ID:</td>
        <td><input type="text" id="sv_agent_id" value="{{ auth()->user()->employee_id ?? '' }}" readonly placeholder="—" oninput="fetchAgentName()"></td>
        <td class="lbl">Agent Name:</td>
        <td><input type="text" id="sv_agent_name" value="{{ auth()->user()->name ?? '' }}" readonly placeholder="Auto-filled from Agent ID"></td>
      </tr>
      <tr>
        <td class="lbl">Team:</td>
        <td>
          @if(auth()->user()->team_name)
            <input type="text" value="{{ auth()->user()->team_name }}" readonly>
            <input type="hidden" id="sv_team_hidden" value="{{ auth()->user()->team_name }}">
          @else
            <select id="sv_team_select">
              <option value="">— Select Team (optional) —</option>
              <option value="">— Corporate —</option>
              <option value="">— Executives —</option>
              <option value="">— TEAM CARL —</option>
              <option value="">— TEAM CYNTHIA —</option>
              <option value="">— TEAM EVELYN —</option>
              @foreach($teams as $team)
                <option value="{{ $team }}">{{ $team }}</option>
              @endforeach
            </select>
          @endif
        </td>
        <td class="lbl">Mode of Visit:</td>
        <td>
          <input type="text" id="sv_mode" list="svVisitTypeOptions" required placeholder="Select or type...">
          <datalist id="svVisitTypeOptions">
            <option value="Actual (On-site)">
            <option value="Online (Virtual)">
          </datalist>
        </td>
      </tr>
      <tr>
        <td class="lbl">Visit Date:</td>
        <td><input type="date" id="sv_date" required min="{{ date('Y-m-d') }}"></td>
        <td class="lbl">Visit Time:</td>
        <td><input type="time" id="sv_time" required></td>
      </tr>
      <tr>
        <td class="lbl">Client Name:</td>
        <td><input type="text" id="sv_client_name" required autocomplete="off" placeholder="Client full name" onblur="checkDuplicateSV()"></td>
        <td class="lbl">Client Email:</td>
        <td><input type="email" id="sv_client_email" placeholder="email@example.com (optional)"></td>
      </tr>
      <tr>
        <td class="lbl">Client Phone:</td>
        <td>
          <div style="display:flex;gap:4px;align-items:center;">
            <input type="text" id="sv_client_phone_code" value="+63" style="width:40px;flex:none;text-align:center;">
            <input type="text" id="sv_client_phone" placeholder="9XX XXX XXXX (optional)" maxlength="15" inputmode="numeric" style="flex:1;">
          </div>
        </td>
        <td class="lbl">Client Address:</td>
        <td><input type="text" id="sv_client_address" placeholder="Home or office address (optional)"></td>
      </tr>
      <tr>
        <td class="lbl">Property Name:</td>
        <td style="position:relative;">
          @if($properties->isNotEmpty())
          <select id="sv_property" required onchange="onPropertySelectSV(this)">
            <option value="">— Select Property —</option>
            @foreach($properties as $prop)
            <option value="{{ $prop->name }}" data-developer="{{ $prop->developer }}">{{ $prop->name }}{{ $prop->developer ? ' ('.$prop->developer.')' : '' }}</option>
            @endforeach
          </select>
          @else
          <input type="text" id="sv_property" required placeholder="Type property name..." autocomplete="off" oninput="svPropertyAutocomplete(this.value)" onblur="setTimeout(checkDuplicateSV,300)">
          <div id="svPropertyAcList" style="display:none;position:absolute;top:100%;left:0;right:0;background:white;border:1px solid #ccc;border-radius:0 0 6px 6px;box-shadow:0 6px 18px rgba(0,0,0,.12);z-index:999;max-height:150px;overflow-y:auto;font-size:12px;"></div>
          @endif
        </td>
        <td class="lbl">Company / Developer:</td>
        <td><input type="text" id="sv_company" placeholder="Developer or company name (optional)"></td>
      </tr>
    </table>

    <!-- Note -->
    <div class="frm-note">
      <strong>Note:</strong> Please double check the client and property details before submitting.
      A client who already has an active or completed site visit for the same property within the last 30 days will be flagged as a duplicate.
    </div>

    <div id="svDupWarning" class="frm-alert frm-alert-warn"></div>
    <div id="svBanner" class="frm-alert"></div>

    <!-- Certification -->
    <hr style="border:none;border-top:1.5px solid #000;margin:10px 0 8px 0;">
    <p style="font-size:11px;font-weight:700;margin:6px 0 8px 0;padding:0;line-height:1.4;">This is to certify that the above information is true and accurate, and that this site visit has been coordinated with the client named above.</p>

    <!-- Signatures -->
    <table class="sigs">
      <tr>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Agent Signature over Printed Name:</td>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Client Signature over Printed Name:</td>
        <td style="padding:4px 8px;font-size:11px;font-weight:400;">Noted by (Sales Admin):</td>
      </tr>
      <tr>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;"></td>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;"></td>
        <td style="padding:4px 8px;height:50px;vertical-align:bottom;font-size:11px;"></td>
      </tr>
      <tr>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
        <td style="padding:4px 8px;font-size:11px;">Date: _______________</td>
      </tr>
    </table>

    <!-- Buttons (screen only) -->
    <div class="frm-btns dept-sel">
      <button class="btn-clear-f" type="button" onclick="clearSVForm()">Clear</button>
      <button class="btn-submit-f" type="button" id="svSubmitBtn" onclick="submitSiteVisit()">Submit Site Visit</button>
      <button class="btn-print-f" type="button" onclick="openPreview('frmCardSV','Site Visit Form')">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print Site Visit Form
      </button>
    </div>

  </div>
  </div>{{-- #frmCardSVWrap --}}
  </div>{{-- #tab-sitevisit --}}

  {{-- ============================= --}}
  {{-- Shared Preview / Print Modal  --}}
  {{-- ============================= --}}
  <div id="frmPreviewModal" class="frm-preview-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center;overflow:hidden;padding:0;">
    <div style="background:white;width:100vw;height:100vh;display:flex;flex-direction:column;box-shadow:none;overflow:hidden;">
      {{-- Modal Header --}}
      <div class="modal-bar" style="background:linear-gradient(135deg,#1e4575,#2563eb);padding:16px 24px;display:flex;align-items:center;justify-content:space-between;">
        <div style="color:white;font-weight:700;font-size:16px;" id="frmPreviewLabel">Preview</div>
        <div style="display:flex;gap:10px;align-items:center;">
          <button onclick="previewDownload()" id="frmDownloadBtn" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF
          </button>
          <button onclick="previewPrint()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:rgba(255,255,255,.15);color:white;border:1px solid rgba(255,255,255,.3);border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print
          </button>
          <button onclick="closePreview()" style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);color:white;width:34px;height:34px;border-radius:8px;cursor:pointer;font-size:18px;display:flex;align-items:center;justify-content:center;">&times;</button>
        </div>
      </div>
      {{-- Modal Body: cloned form --}}
      <div class="modal-body-pad" style="padding:20px;display:flex;justify-content:center;align-items:center;flex:1;min-height:0;overflow:hidden;"><div id="frmPreviewBody" style="background:white;box-shadow:0 4px 24px rgba(0,0,0,.3);width:100%;max-width:816px;"></div></div>
    </div>
  </div>

<script>
/* ============================================================
   MOBILE AUTO-SCALE
   Shrinks the fixed 816px-wide printable card to fit narrow
   screens using a CSS transform (visual-only), so the on-screen
   layout, print output, and generated PDF stay pixel-identical
   to desktop. See generatePDF() for the temporary reset used
   while capturing, so PDFs are never rendered at reduced scale.
   ============================================================ */
function fitCardToWidth(card){
  if(!card) return;
  var wrap = card.parentElement;
  if(!wrap) return;
  var prevTransform = card.style.transform;
  card.style.transform = 'none';
  var natural = card.offsetWidth;
  var avail = wrap.clientWidth;
  // Guard against transient 0/near-0 width readings (e.g. mobile layout
  // not fully settled yet at DOMContentLoaded — sidebar/backdrop still
  // transitioning). Without this, a stray tiny measurement bakes in
  // scale(~0) and a 0px wrapper height that never self-corrects.
  if(!natural || avail < 40){ card.style.transform = prevTransform; return; }
  var scale = Math.min(1, avail / natural);
  if(scale < 0.999){
    card.style.transformOrigin = 'top left';
    card.style.transform = 'scale(' + scale + ')';
    wrap.style.height = Math.ceil(card.offsetHeight * scale) + 'px';
  } else {
    card.style.transform = 'none';
    wrap.style.height = 'auto';
  }
}
function fitPreviewCard(){
  var card = document.querySelector('#frmPreviewBody .frm-card');
  var wrapper = document.getElementById('frmPreviewBody');
  var bodyPad = document.querySelector('#frmPreviewModal .modal-body-pad');
  if(!card || !bodyPad || !wrapper) return;
  card.style.transform = 'none';
  wrapper.style.width = '';
  wrapper.style.height = '';
  var natW = card.offsetWidth, natH = card.offsetHeight;
  var availW = bodyPad.clientWidth - 40;
  var availH = bodyPad.clientHeight - 40;
  if(!natW || !natH || availW < 40 || availH < 40) return;
  var scale = Math.min(1, availW / natW, availH / natH);
  card.style.transformOrigin = 'top left';
  card.style.transform = scale < 0.999 ? 'scale(' + scale + ')' : 'none';
  // Shrink the wrapper box to the scaled visual size so flex centering
  // (align-items/justify-content: center) positions the form correctly
  // instead of centering around its old, unscaled layout box.
  wrapper.style.width = (natW * scale) + 'px';
  wrapper.style.height = (natH * scale) + 'px';
}
function fitAllFormCards(){
  fitCardToWidth(document.getElementById('frmCard'));
  fitCardToWidth(document.getElementById('frmCardSV'));
  var previewCard = document.querySelector('#frmPreviewBody .frm-card');
  if(previewCard) fitCardToWidth(previewCard);
}
var _fitResizeTimer;
window.addEventListener('resize', function(){
  clearTimeout(_fitResizeTimer);
  _fitResizeTimer = setTimeout(function(){
    fitAllFormCards();
    if(document.getElementById('frmPreviewModal').style.display === 'flex') fitPreviewCard();
  }, 120);
});
document.addEventListener('DOMContentLoaded', function(){
  // A single setTimeout(fn, 0) right after DOMContentLoaded can still
  // land mid-layout on mobile (sidebar drawer/backdrop transitions,
  // late webfont metrics). Retry across a few animation frames so we
  // don't lock in a bad measurement, then double-check after window
  // 'load' once images/fonts are fully in.
  var attempts = 0;
  (function attempt(){
    fitAllFormCards();
    attempts++;
    if(attempts < 8) requestAnimationFrame(attempt);
  })();
});
window.addEventListener('load', function(){
  requestAnimationFrame(fitAllFormCards);
});

/* ============================================================
   TAB SWITCHING
   ============================================================ */
function switchFormsTab(tab){
  document.getElementById('tab-budget').style.display = tab==='budget' ? '' : 'none';
  document.getElementById('tab-sitevisit').style.display = tab==='sitevisit' ? '' : 'none';
  var url = new URL(window.location.href);
  url.searchParams.set('tab', tab === 'sitevisit' ? 'site-visit' : 'budget');
  history.replaceState(null, '', url);
  // The tab that just became visible needs its width re-measured, but a
  // single setTimeout(fn, 0) can still land before mobile layout has
  // settled (this is exactly what caused the Site Visit form to load
  // blank on mobile even though Budget worked — Budget only needed the
  // page-load retry loop below, but Site Visit only becomes visible
  // through this function). Retry across a few frames here too.
  var attempts = 0;
  (function attempt(){
    fitAllFormCards();
    attempts++;
    if(attempts < 8) requestAnimationFrame(attempt);
  })();
}
document.addEventListener('DOMContentLoaded', function(){
  var params = new URLSearchParams(window.location.search);
  var t = params.get('tab');
  switchFormsTab(t === 'site-visit' || t === 'sitevisit' ? 'sitevisit' : 'budget');
});

/* ============================================================
   BUDGET REQUEST FORM LOGIC
   ============================================================ */
var _deptCategories = {};
@foreach($departments->where('slug', '!=', 'capex') as $dept)
_deptCategories['{{ strtoupper($dept->name) }}'] = [
  @foreach($dept->categories as $cat)'{{ addslashes($cat->name) }}',@endforeach
];
@endforeach

function updDept(){
  var v = document.getElementById('f_dept').value;
  document.getElementById('disp_dept').textContent = v ? v + ' DEPARTMENT' : 'DEPARTMENT';

  var list = document.getElementById('f_cat_list');
  list.innerHTML = '';
  var cats = _deptCategories[v] || [];
  cats.forEach(function(cat){
    var opt = document.createElement('option');
    opt.value = cat;
    list.appendChild(opt);
  });

  document.getElementById('f_cat').value = '';
}
window._frmNames = @json($requestorNames ?? []);
function showNameSuggestions(val){
  var box=document.getElementById('nameSuggestBox');
  if(!val||val.trim().length<2){box.style.display='none';return;}
  var names=window._frmNames||[];
  var q=val.toLowerCase();
  var matches=names.filter(function(n){return n.toLowerCase().indexOf(q)===0;});
  if(!matches.length){box.style.display='none';return;}
  box.innerHTML=matches.map(function(n){
    return '<div style="padding:7px 12px;cursor:pointer;" onmousedown="pickName(\''+n.replace(/'/g,"\\'")+'\')" onmouseover="this.style.background=\'#f1f5f9\'" onmouseout="this.style.background=\'white\'">'+n+'</div>';
  }).join('');
  box.style.display='block';
}
function pickName(n){
  document.getElementById('f_name').value=n;
  document.getElementById('nameSuggestBox').style.display='none';
}
function addToNameList(val){
  document.getElementById('nameSuggestBox').style.display='none';
}
document.addEventListener('click',function(e){
  if(e.target.id!=='f_name') document.getElementById('nameSuggestBox').style.display='none';
});
function clearForm(){
  ['f_name','f_date_req','f_target','f_amount','f_remarks','f_cat'].forEach(function(id){document.getElementById(id).value='';});
  document.getElementById('f_dept').value='HUMAN RESOURCES';
  updDept();
}
// Load control number on page load
var _ctrlNum = '';
fetch('{{ url("/api/forms/control-number") }}')
  .then(function(r){return r.json();})
  .then(function(d){
    _ctrlNum = d.control_number;
    var parts = d.control_number.split('-');
    var html = parts[0] + '-'
      + '<span style="text-decoration:underline;">' + parts[1] + '</span>-'
      + '<span style="text-decoration:underline;">' + parts[2] + '</span>-'
      + '<span style="text-decoration:underline;">' + parts[3] + '</span>';
    document.getElementById('ctrlNumDisplay').innerHTML = html;
  });

function incrementAndPrint(){
  fetch('{{ url("/api/forms/control-number/increment") }}', {
    method:'POST',
    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}
  }).then(function(){window.print();});
}

// Populate categories for default department on load
document.addEventListener('DOMContentLoaded', function(){ updDept(); });

/* ============================================================
   SITE VISIT FORM LOGIC
   ============================================================ */
function fetchAgentName(){
  var empId = document.getElementById('sv_agent_id').value.trim();
  var nameField = document.getElementById('sv_agent_name');
  if(!empId){ nameField.value=''; return; }
  fetch('/api/tripping/agent-details?employee_id='+encodeURIComponent(empId))
    .then(function(r){return r.json();})
    .then(function(d){
      if(d.found){
        nameField.value = (d.salutation ? d.salutation+' ' : '') + d.name;
      }
    }).catch(function(){});
}
document.addEventListener('DOMContentLoaded', fetchAgentName);

function onPropertySelectSV(sel){
  var opt = sel.options[sel.selectedIndex];
  var dev = opt ? opt.getAttribute('data-developer') : '';
  if (dev) document.getElementById('sv_company').value = dev;
  checkDuplicateSV();
}

var svPropTimer;
function svPropertyAutocomplete(q){
  clearTimeout(svPropTimer);
  var list = document.getElementById('svPropertyAcList');
  if(!list) return;
  if(!q || !q.trim()){ list.style.display='none'; return; }
  svPropTimer = setTimeout(function(){
    fetch('/api/tripping/properties?q='+encodeURIComponent(q))
      .then(function(r){return r.json();})
      .then(function(data){
        if(!data.length){ list.style.display='none'; return; }
        list.innerHTML = data.map(function(name){
          return '<div style="padding:8px 12px;cursor:pointer;" onmousedown="svPickProperty(\''+name.replace(/'/g,"\\'")+'\')" onmouseover="this.style.background=\'#f0f4ff\'" onmouseout="this.style.background=\'white\'">'+name+'</div>';
        }).join('');
        list.style.display='block';
      });
  }, 250);
}
function svPickProperty(name){
  document.getElementById('sv_property').value = name;
  document.getElementById('svPropertyAcList').style.display='none';
  fetch('/api/tripping/property-details?name='+encodeURIComponent(name))
    .then(function(r){return r.json();})
    .then(function(d){ document.getElementById('sv_company').value = d.company || ''; });
  checkDuplicateSV();
}
document.addEventListener('click', function(e){
  var list = document.getElementById('svPropertyAcList');
  var input = document.getElementById('sv_property');
  if(list && input && e.target !== input && !list.contains(e.target)) list.style.display='none';
});

var svDupTimer;
function checkDuplicateSV(){
  clearTimeout(svDupTimer);
  svDupTimer = setTimeout(function(){
    var clientEl = document.getElementById('sv_client_name');
    var propEl = document.getElementById('sv_property');
    var client = clientEl ? clientEl.value.trim() : '';
    var property = propEl ? propEl.value.trim() : '';
    var warn = document.getElementById('svDupWarning');
    var btn = document.getElementById('svSubmitBtn');
    if(!client || !property){ warn.classList.remove('show'); return; }
    fetch('/api/tripping/check-duplicate?client_name='+encodeURIComponent(client)+'&property_name='+encodeURIComponent(property))
      .then(function(r){return r.json();})
      .then(function(d){
        if(d.duplicate){
          warn.innerHTML = '&#9888; '+client+' already has an active tripping for '+property+(d.date?' on '+d.date:'')+'. Status: '+d.status+'.';
          warn.classList.add('show');
          btn.disabled = true;
        } else {
          warn.classList.remove('show');
          btn.disabled = false;
        }
      });
  }, 400);
}

function svBanner(msg, type){
  var b = document.getElementById('svBanner');
  b.className = 'frm-alert show ' + (type==='error' ? 'frm-alert-error' : 'frm-alert-success');
  b.innerHTML = msg;
}

function collectSVData(){
  var teamHidden = document.getElementById('sv_team_hidden');
  var teamSelect = document.getElementById('sv_team_select');
  return {
    agent_name: (document.getElementById('sv_agent_id').value || '').trim(),
    team_name: teamHidden ? teamHidden.value : (teamSelect ? teamSelect.value : ''),
    client_name: document.getElementById('sv_client_name').value.trim(),
    client_email: document.getElementById('sv_client_email').value.trim(),
    client_phone: document.getElementById('sv_client_phone').value.trim(),
    client_phone_code: document.getElementById('sv_client_phone_code').value.trim() || '+63',
    client_address: document.getElementById('sv_client_address').value.trim(),
    property_name: document.getElementById('sv_property').value.trim(),
    company_name: document.getElementById('sv_company').value.trim(),
    tripping_date: document.getElementById('sv_date').value,
    tripping_time: document.getElementById('sv_time').value,
    tripping_type: document.getElementById('sv_mode').value.trim()
  };
}

function clearSVForm(){
  ['sv_client_name','sv_client_email','sv_client_phone','sv_client_address','sv_company','sv_date','sv_time','sv_mode'].forEach(function(id){
    var el = document.getElementById(id);
    if(el) el.value = '';
  });
  var propEl = document.getElementById('sv_property');
  if(propEl) propEl.value = '';
  var teamSelect = document.getElementById('sv_team_select');
  if(teamSelect) teamSelect.value = '';
  document.getElementById('svDupWarning').classList.remove('show');
  document.getElementById('svBanner').classList.remove('show');
  document.getElementById('svStatusDisplay').textContent = 'Not Yet Submitted';
  document.getElementById('svStatusDisplay').style.color = '#dc2626';
  var btn = document.getElementById('svSubmitBtn');
  btn.disabled = false;
  btn.textContent = 'Submit Site Visit';
}

function submitSiteVisit(){
  var data = collectSVData();
  var errors = [];
  if(!data.client_name) errors.push('Client name is required.');
  if(!data.property_name) errors.push('Property name is required.');
  if(!data.tripping_date) errors.push('Visit date is required.');
  if(!data.tripping_time) errors.push('Visit time is required.');
  if(!data.tripping_type) errors.push('Mode of visit is required.');
  if(errors.length){
    svBanner(errors.map(function(m){return '&#9888; '+m;}).join('<br>'), 'error');
    return;
  }

  var btn = document.getElementById('svSubmitBtn');
  btn.disabled = true;
  btn.textContent = 'Submitting...';

  fetch('{{ route("tripping.store") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
  })
  .then(function(r){ return r.json().then(function(j){ return {status:r.status, body:j}; }); })
  .then(function(res){
    if(res.status === 200 && res.body.success){
      svBanner('&#10003; Site visit scheduled successfully! You can now print or download the form below.', 'success');
      document.getElementById('svStatusDisplay').textContent = 'Confirmed \u2713';
      document.getElementById('svStatusDisplay').style.color = '#16a34a';
      btn.textContent = 'Submitted';

      var teamSelect = document.getElementById('sv_team_select');
      if(teamSelect && teamSelect.value){
        fetch('{{ route("tripping.save-team") }}', {
          method: 'POST',
          headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
          body: JSON.stringify({team_name: teamSelect.value})
        });
      }
    } else {
      var msgs = res.body.errors ? Object.values(res.body.errors).flat() : [res.body.message || 'Something went wrong. Please try again.'];
      svBanner(msgs.map(function(m){return '&#9888; '+m;}).join('<br>'), 'error');
      btn.disabled = false;
      btn.textContent = 'Submit Site Visit';
    }
  })
  .catch(function(){
    svBanner('&#9888; Network error. Please try again.', 'error');
    btn.disabled = false;
    btn.textContent = 'Submit Site Visit';
  });
}

/* ============================================================
   SHARED PREVIEW / PRINT / PDF MODAL
   ============================================================ */
function openPreview(cardId, label){
  document.body.appendChild(document.getElementById('frmPreviewModal'));
  var clone = document.getElementById(cardId).cloneNode(true);
  clone.querySelectorAll('.frm-btns,.dept-sel').forEach(function(el){ el.remove(); });
  clone.style.transform = 'none';
  clone.removeAttribute('id');
  document.getElementById('frmPreviewBody').innerHTML = '';
  document.getElementById('frmPreviewBody').appendChild(clone);
  document.getElementById('frmPreviewLabel').textContent = label + ' — Preview';
  var modal = document.getElementById('frmPreviewModal');
  modal.dataset.source = cardId;
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  setTimeout(fitPreviewCard, 0);
}
function closePreview(){
  document.getElementById('frmPreviewModal').style.display = 'none';
  document.body.style.overflow = '';
}
function previewPrint(){
  var src = document.getElementById('frmPreviewModal').dataset.source;
  if(src === 'frmCard'){ incrementAndPrint(); } else { window.print(); }
}
function previewDownload(){
  var src = document.getElementById('frmPreviewModal').dataset.source;
  if(src === 'frmCard'){
    var ctrlEl = document.getElementById('ctrlNumDisplay');
    var ctrlNum = ctrlEl ? ctrlEl.textContent.trim() : 'Budget-Request-Form';
    generatePDF('frmCard', ctrlNum, true);
  } else {
    var cnameEl = document.getElementById('sv_client_name');
    var cname = (cnameEl && cnameEl.value ? cnameEl.value.trim() : 'Site-Visit').replace(/\s+/g,'-');
    generatePDF('frmCardSV', 'Site-Visit-' + cname, false);
  }
}
function generatePDF(cardId, filename, incrementCtrl){
  var dlBtn=document.getElementById('frmDownloadBtn');
  if(dlBtn) dlBtn.disabled=true;
  var el=document.getElementById(cardId);
  var wrap=el.parentElement;
  // Capture at full, unscaled size so mobile viewing scale never affects PDF quality
  el.style.transform='none';
  if(wrap) wrap.style.height='auto';
  el.querySelectorAll('.frm-btns,.dept-sel').forEach(e=>e.style.display='none');
  var replacements=[];
  el.querySelectorAll('input,textarea,select').forEach(function(field){
    var span=document.createElement('span');
    var value=field.tagName==='SELECT'?(field.options[field.selectedIndex]?.text||''):(field.value||'');
    span.textContent=value;
    var cs=getComputedStyle(field);
    span.style.cssText='display:inline-block;white-space:pre-wrap;vertical-align:middle;';
    span.style.width=field.offsetWidth+'px';
    span.style.minHeight=field.offsetHeight+'px';
    span.style.font=cs.font;
    span.style.padding=cs.padding;
    span.style.margin=cs.margin;
    span.style.border='none';
    field.style.display='none';
    field.parentNode.insertBefore(span,field);
    replacements.push({field:field,span:span});
  });
  function cleanup(){
    replacements.forEach(r=>{r.span.remove();r.field.style.display='';});
    el.querySelectorAll('.frm-btns,.dept-sel').forEach(e=>e.style.display='');
    if(dlBtn) dlBtn.disabled=false;
    // Re-apply mobile auto-fit scaling now that the full-size capture is done
    fitCardToWidth(el);
  }
  function render(){
    html2canvas(el,{scale:3,useCORS:true,backgroundColor:'#fff'}).then(function(canvas){
      var pdf=new window.jspdf.jsPDF({orientation:'portrait',unit:'in',format:'letter'});
      pdf.addImage(canvas.toDataURL('image/jpeg',1),'JPEG',0,0,8.5,11);
      pdf.save(filename+'.pdf');
      cleanup();
    }).catch(cleanup);
  }
  if(incrementCtrl){
    fetch('{{ url("/api/forms/control-number/increment") }}',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}}).then(render);
  } else render();
}
document.getElementById('frmPreviewModal').addEventListener('click', function(e){
  if(e.target === this) closePreview();
});
</script>

<!-- html2canvas + jsPDF for real PDF download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</div>{{-- .frm-wrap --}}

@endsection