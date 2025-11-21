@extends('layouts.app')

@section('content')
<style>
/* -------------------------
   Menu styles (kept light)
   ------------------------- */

   .container{
    margin-top: 0px;
    padding-top: 0px;
   }
.menu-section-title { font-size: 28px; font-weight:700; margin-top:45px; margin-bottom:20px; color:#f8f9fa; border-left:5px solid #ffc107; padding-left:10px; }
.menu-card { background:#1b1b1b; border-radius:14px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.4); transition:transform .2s; }
.menu-card:hover { transform: translateY(-4px); }
.menu-card img { width:100%; height:160px; object-fit:cover; }
.menu-card-body { padding:20px; width: 100% }
.availability-tag { padding:5px 10px; font-size:12px; border-radius:30px; display:inline-block; margin-bottom:10px; }
.daily { background:#198754; color:#fff; } .ondemand { background:#0d6efd; color:#fff; }
.menu-item-name { font-size:19px; font-weight:700; color:#fff; }
.menu-item-description { color:#ccc; font-size:14px; margin-top:6px; }
.menu-item-price { color:#ffc107; font-weight:700; font-size:20px; margin-top:12px; }
.modal-backdrop{display:none !important;}
.btn-custom { background:#ffc107; border:none; color:#000; font-weight:600; }
.btn-outline-custom { border:2px solid #ffc107; color:#ffc107; font-weight:600; font-size: 15px; }
.btn-outline-custom:hover { background:#ffc107; color:#000; }
.modal-content { background:#111; color:white; border-radius:10px; }
.addon-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
.addon-controls { display:flex; gap:6px; align-items:center; }
.addon-qty { width:46px; text-align:center; background:transparent; color:white; border:none; }
.qty-controls { display:flex; gap:8px; align-items:center; }
.small-muted { color:#bfbfbf; font-size:13px; }
.modal-sm-custom { max-width:520px; }
@media (max-width:576px) { .modal-sm-custom { max-width: 92%; } }

.menu-card .btn {
    font-size: 10px !important;   /* slightly smaller text */
    padding: 6px 5px !important;
    white-space: nowrap !important;  /* prevents text from breaking */
}

.menu-card .d-flex {
    gap: 20px !important;             /* reduce gap between buttons */
}


/* Make custom small modal */
.modal-sm-custom .modal-content {
    max-width: 660px;
    margin: 0 auto;
    border-radius: 12px;
}

/* Allow smooth scroll inside the modal body */
.modal-dialog-scrollable .modal-body {
    max-height: 40vh; 
    overflow-y: auto;
}

/* Optional: reduce padding inside modal */
.modal-sm-custom .modal-content {
    padding: 10px !important;
}

/* Make header compact */
.modal-sm-custom .modal-header {
    padding: 8px 12px !important;
}

/* Fix huge empty space under navbar on mobile */
@media (max-width: 576px) {
    body {
        padding-top: 70px !important; /* reduce space */
    }

    .menu-section-title {
        margin-top: 10px !important;
    }
}
.menu-card {
    background: #1b1b1b;
    border-radius: 10px;
    overflow: hidden;
    height: 100%;
}

.menu-card img {
    width: 100%;
    height: 130px;
    object-fit: cover;
}

@media (max-width: 576px) {
    .menu-card img {
        height: 110px;
    }

    .menu-item-name {
        font-size: 14px !important;
    }

    .menu-item-description {
        font-size: 11px !important;
    }

    .menu-item-price {
        font-size: 14px !important;
    }
}


</style>

<div class="container py-1 pt-0">
    @foreach($categories as $category)
        <h2 class="menu-section-title">{{ $category->name }}</h2>

        <div class="row g-4 mb-5">
            @forelse($category->items as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="menu-card">
                        <img src="{{ asset($item->image ? 'storage/'.$item->image : 'assets/placeholder_food.jpg') }}" alt="{{ $item->name }}">
                        <div class="menu-card-body">

                            @if(!empty($item->availability))
                                <span class="availability-tag {{ strtolower($item->availability) === 'daily' ? 'daily' : 'ondemand' }}">
                                    {{ $item->availability }}
                                </span>
                            @endif

                            <div class="menu-item-name">{{ $item->name }}</div>
                            <div class="menu-item-description">{{ \Illuminate\Support\Str::limit($item->description ?? '', 120) }}</div>
                            <div class="menu-item-price">₦{{ number_format($item->price) }}</div>

                            <div class="d-flex gap-2 mt-3">
                                <!-- Order now: immediately send default order (no customization) -->
                                <button class="btn btn-custom w-50 order-now-btn"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-price="{{ $item->price }}">
                                    Order Now
                                </button>

                                <!-- Customize: opens appropriate modal based on category -->
                                <button class="btn btn-outline-custom w-50 customize-btn"
                                        data-id="{{ $item->id }}"
                                        data-category="{{ strtolower($category->name) }}">
                                    Customize
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light">No items in this category yet.</div>
                </div>
            @endforelse
        </div>
    @endforeach
</div>

<!-- ============================
     C O M M O N   M O D A L S
     (small, scrollable)
     ============================ -->

<!-- Cuisine Modal -->
<div class="modal fade" id="modalCuisine" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm-custom">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="cuisineItemName">Customize</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="cuisineItemImage" class="mb-2 text-center"></div>
        <div class="mb-2">
            <div class="menu-item-price" id="cuisineItemPrice"></div>
            <div class="small-muted" id="cuisineItemDesc"></div>
        </div>

        <hr>
        <h6 class="text-warning">Add-ons</h6>
        <div id="cuisineAddonsList" class="mb-3"><!-- dynamic addons with +/- --></div>

        <h6 class="text-warning">Preferences</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cuisinePrefNoOnion">
            <label class="form-check-label" for="cuisinePrefNoOnion">No onion</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cuisinePrefNoCrayfish">
            <label class="form-check-label" for="cuisinePrefNoCrayfish">No crayfish</label>
        </div>

        <hr>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="qty-controls">
                <button class="btn btn-sm btn-outline-light" id="cuisineQtyMinus">-</button>
                <input type="text" id="cuisineQtyInput" value="1" style="width:48px; text-align:center; background:transparent; color:white; border:none;">
                <button class="btn btn-sm btn-outline-light" id="cuisineQtyPlus">+</button>
            </div>

            <div>
                <div class="small text-white">Total</div>
                <div class="fw-bold" id="cuisineTotalPrice">₦0</div>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-light modal-whatsapp-btn"><i class="bi bi-whatsapp"></i> Order via WhatsApp</button>
        <button type="button" class="btn btn-custom modal-complete-btn">Complete Order</button>
      </div>
    </div>
  </div>
</div>



<!-- Drinks Modal -->
<div class="modal fade" id="modalDrinks" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm-custom">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="drinksItemName">Order</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="drinksItemImage" class="mb-2 text-center"></div>
        <div class="mb-2">
            <div class="menu-item-price" id="drinksItemPrice"></div>
            <div class="small-muted" id="drinksItemDesc"></div>
        </div>

        <hr>
        <!-- Drinks: no add-on preferences, only qty -->
        <div class="small-muted mb-3">Select quantity</div>

        <div class="d-flex justify-content-between align-items-center">
            <div class="qty-controls">
                <button class="btn btn-sm btn-outline-light" id="drinksQtyMinus">-</button>
                <input type="text" id="drinksQtyInput" value="1" style="width:48px; text-align:center; background:transparent; color:white; border:none;">
                <button class="btn btn-sm btn-outline-light" id="drinksQtyPlus">+</button>
            </div>

            <div>
                <div class="small text-white">Total</div>
                <div class="fw-bold" id="drinksTotalPrice">₦0</div>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-light modal-whatsapp-btn"><i class="bi bi-whatsapp"></i> Order via WhatsApp</button>
        <button type="button" class="btn btn-custom modal-complete-btn">Complete Order</button>
      </div>
    </div>
  </div>
</div>

<!-- Grill Modal -->
<div class="modal fade" id="modalGrill" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm-custom">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="grillItemName">Customize Grill</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="grillItemImage" class="mb-2 text-center"></div>
        <div class="mb-2">
            <div class="menu-item-price" id="grillItemPrice"></div>
            <div class="small-muted" id="grillItemDesc"></div>
        </div>

        <hr>
        <h6 class="text-warning">Add-ons (e.g. extra skewers)</h6>
        <div id="grillAddonsList" class="mb-3"></div>

        <h6 class="text-warning">Preferences</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="grillPrefNoOnion">
            <label class="form-check-label" for="grillPrefNoOnion">No onion</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="grillPrefNoVeg">
            <label class="form-check-label" for="grillPrefNoVeg">No vegetables</label>
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <div class="qty-controls">
                <button class="btn btn-sm btn-outline-light" id="grillQtyMinus">-</button>
                <input type="text" id="grillQtyInput" value="1" style="width:48px; text-align:center; background:transparent; color:white; border:none;">
                <button class="btn btn-sm btn-outline-light" id="grillQtyPlus">+</button>
            </div>

            <div>
                <div class="small text-white">Total</div>
                <div class="fw-bold" id="grillTotalPrice">₦0</div>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-light modal-whatsapp-btn"><i class="bi bi-whatsapp"></i> Order via WhatsApp</button>
        <button type="button" class="btn btn-custom modal-complete-btn">Complete Order</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // helper: format price
    function formatPrice(n){ return '₦' + new Intl.NumberFormat().format(n); }

    // universal fetch endpoint for item data
    async function fetchItem(id){
        const res = await fetch(`/menu/item/${id}`);
        if(!res.ok) throw new Error('Item not found');
        return await res.json();
    }

    // universal rendering helpers
    function createAddonRow(addon, prefix){
        // prefix: 'cuisine' or 'grill'
        const wrapper = document.createElement('div');
        wrapper.className = 'addon-row';
        wrapper.innerHTML = `
            <div>
                <div class="fw-semibold addon-name">${addon.name}</div>
                <div class="small-muted">+ ${formatPrice(addon.price)}</div>
            </div>
            <div class="addon-controls">
                <button class="btn btn-sm btn-outline-light addon-minus" data-id="${addon.id}" data-price="${addon.price}">-</button>
                <input type="text" value="0" class="addon-qty" data-id="${addon.id}" data-price="${addon.price}">
                <button class="btn btn-sm btn-outline-light addon-plus" data-id="${addon.id}" data-price="${addon.price}">+</button>
            </div>
        `;
        return wrapper;
    }

    // attach behavior to cards (customize)
    document.querySelectorAll('.customize-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const category = (btn.dataset.category || '').toLowerCase();

            try {
                const item = await fetchItem(id);

                // determine modal type by category name heuristics
                if(category.includes('drink')) {
                    populateDrinksModal(item);
                    new bootstrap.Modal(document.getElementById('modalDrinks')).show();
                } else if(category.includes('grill') || category.includes('grilled')) {
                    populateGrillModal(item);
                    new bootstrap.Modal(document.getElementById('modalGrill')).show();
                } else {
                    // default to cuisine modal
                    populateCuisineModal(item);
                    new bootstrap.Modal(document.getElementById('modalCuisine')).show();
                }
            } catch (err) {
                console.error(err);
                alert('Could not load item details. Refresh and try again.');
            }
        });
    });

    // ORDER NOW buttons (quick whatsapp)
    document.querySelectorAll('.order-now-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const name = btn.dataset.name;
            const price = Number(btn.dataset.price || 0);
            const qty = 1;
            const total = price * qty;
            const msg = `Order: ${name}%0AQty: ${qty}%0ATotal: ${formatPrice(total)}%0ANotes: None`;
            const phone = '+2347087766823'; //  Testing WhatsApp number
            window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`, '_blank');
        });
    });

    // ---------------------------
    // Populate each modal type
    // ---------------------------

    // Cuisine modal
    function populateCuisineModal(item){
        // set base fields
        document.getElementById('cuisineItemName').textContent = item.name;
        document.getElementById('cuisineItemPrice').textContent = formatPrice(item.price);
        document.getElementById('cuisineItemDesc').textContent = item.description || '';
        document.getElementById('cuisineItemImage').innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        // reset quantities and prefs
        document.getElementById('cuisineQtyInput').value = 1;
        document.getElementById('cuisinePrefNoOnion').checked = false;
        document.getElementById('cuisinePrefNoCrayfish').checked = false;

        // render addons (plus/minus)
        const list = document.getElementById('cuisineAddonsList');
        list.innerHTML = '';
        const addons = item.addons || [];
        if(addons.length === 0){
            list.innerHTML = '<div class="small-muted">No add-ons available</div>';
        } else {
            addons.forEach(a => list.appendChild(createAddonRow(a, 'cuisine')));
        }

        // attach addon plus/minus logic for cuisine
        attachAddonControls(list);

        // recalc initial total
        window._cuisine = { base_price: Number(item.price || 0) };
        recalcCuisineTotal();
    }

    function attachAddonControls(listEl){
        // plus
        listEl.querySelectorAll('.addon-plus').forEach(btn => {
            btn.onclick = () => {
                const input = btn.parentElement.querySelector('.addon-qty');
                input.value = Math.max(0, Number(input.value || 0) + 1);
                recalcAllTotals();
            };
        });
        // minus
        listEl.querySelectorAll('.addon-minus').forEach(btn => {
            btn.onclick = () => {
                const input = btn.parentElement.querySelector('.addon-qty');
                input.value = Math.max(0, Number(input.value || 0) - 1);
                recalcAllTotals();
            };
        });
        // direct input change
        listEl.querySelectorAll('.addon-qty').forEach(inp => {
            inp.addEventListener('input', () => { inp.value = Math.max(0, Number(inp.value || 0)); recalcAllTotals(); });
        });
    }

    // Drinks modal
    function populateDrinksModal(item){
        document.getElementById('drinksItemName').textContent = item.name;
        document.getElementById('drinksItemPrice').textContent = formatPrice(item.price);
        document.getElementById('drinksItemDesc').textContent = item.description || '';
        document.getElementById('drinksItemImage').innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        document.getElementById('drinksQtyInput').value = 1;
        window._drinks = { base_price: Number(item.price || 0) };
        recalcDrinksTotal();
    }

    // Grill modal
    function populateGrillModal(item){
        document.getElementById('grillItemName').textContent = item.name;
        document.getElementById('grillItemPrice').textContent = formatPrice(item.price);
        document.getElementById('grillItemDesc').textContent = item.description || '';
        document.getElementById('grillItemImage').innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        document.getElementById('grillQtyInput').value = 1;
        document.getElementById('grillPrefNoOnion').checked = false;
        document.getElementById('grillPrefNoVeg').checked = false;

        const list = document.getElementById('grillAddonsList');
        list.innerHTML = '';
        const addons = item.addons || [];
        if(addons.length === 0){
            list.innerHTML = '<div class="small-muted">No add-ons available</div>';
        } else {
            addons.forEach(a => list.appendChild(createAddonRow(a, 'grill')));
        }
        attachAddonControls(list);

        window._grill = { base_price: Number(item.price || 0) };
        recalcGrillTotal();
    }

    // ---------------------------
    // Quantity controls and recalc
    // ---------------------------

    // cuisine qty buttons
    document.getElementById('cuisineQtyPlus').addEventListener('click', ()=> {
        const el = document.getElementById('cuisineQtyInput'); el.value = Math.max(1, Number(el.value) + 1); recalcCuisineTotal();
    });
    document.getElementById('cuisineQtyMinus').addEventListener('click', ()=> {
        const el = document.getElementById('cuisineQtyInput'); el.value = Math.max(1, Number(el.value) - 1); recalcCuisineTotal();
    });
    document.getElementById('cuisineQtyInput').addEventListener('input', ()=> { document.getElementById('cuisineQtyInput').value = Math.max(1, Number(document.getElementById('cuisineQtyInput').value || 1)); recalcCuisineTotal(); });

    function recalcCuisineTotal(){
        const cur = window._cuisine;
        if(!cur) return;
        const qty = Number(document.getElementById('cuisineQtyInput').value || 1);
        let addonsTotal = 0;
        document.querySelectorAll('#cuisineAddonsList .addon-qty').forEach(i => addonsTotal += Number(i.value || 0) * Number(i.dataset.price || 0));
        const total = (cur.base_price + addonsTotal) * qty;
        document.getElementById('cuisineTotalPrice').textContent = formatPrice(total);
    }

    // drinks qty
    document.getElementById('drinksQtyPlus').addEventListener('click', ()=> {
        const el = document.getElementById('drinksQtyInput'); el.value = Math.max(1, Number(el.value) + 1); recalcDrinksTotal();
    });
    document.getElementById('drinksQtyMinus').addEventListener('click', ()=> {
        const el = document.getElementById('drinksQtyInput'); el.value = Math.max(1, Number(el.value) - 1); recalcDrinksTotal();
    });
    document.getElementById('drinksQtyInput').addEventListener('input', ()=> { document.getElementById('drinksQtyInput').value = Math.max(1, Number(document.getElementById('drinksQtyInput').value || 1)); recalcDrinksTotal(); });

    function recalcDrinksTotal(){
        const cur = window._drinks;
        if(!cur) return;
        const qty = Number(document.getElementById('drinksQtyInput').value || 1);
        const total = cur.base_price * qty;
        document.getElementById('drinksTotalPrice').textContent = formatPrice(total);
    }

    // grill qty
    document.getElementById('grillQtyPlus').addEventListener('click', ()=> {
        const el = document.getElementById('grillQtyInput'); el.value = Math.max(1, Number(el.value) + 1); recalcGrillTotal();
    });
    document.getElementById('grillQtyMinus').addEventListener('click', ()=> {
        const el = document.getElementById('grillQtyInput'); el.value = Math.max(1, Number(el.value) - 1); recalcGrillTotal();
    });
    document.getElementById('grillQtyInput').addEventListener('input', ()=> { document.getElementById('grillQtyInput').value = Math.max(1, Number(document.getElementById('grillQtyInput').value || 1)); recalcGrillTotal(); });

    function recalcGrillTotal(){
        const cur = window._grill;
        if(!cur) return;
        const qty = Number(document.getElementById('grillQtyInput').value || 1);
        let addonsTotal = 0;
        document.querySelectorAll('#grillAddonsList .addon-qty').forEach(i => addonsTotal += Number(i.value || 0) * Number(i.dataset.price || 0));
        const total = (cur.base_price + addonsTotal) * qty;
        document.getElementById('grillTotalPrice').textContent = formatPrice(total);
    }

    // Recalc helper used by addon controls
    function recalcAllTotals(){
        recalcCuisineTotal(); recalcGrillTotal(); recalcDrinksTotal();
    }

    // Listen to addon qty changes anywhere (delegated) - update totals
    document.addEventListener('input', function(e){
        if(e.target && e.target.classList.contains('addon-qty')) recalcAllTotals();
        if(e.target && e.target.classList.contains('addon-qty')) recalcAllTotals();
    });

    // ---------------------------
    // Modal footer buttons (WhatsApp + Complete)
    // ---------------------------
    // All modal whatsapp buttons share logic: read current visible modal fields
    document.querySelectorAll('.modal-whatsapp-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // determine which modal is visible
            const visible = document.querySelector('.modal.show');
            if(!visible) return alert('No modal active');
            if(visible.id === 'modalDrinks') return sendDrinksWhatsApp();
            if(visible.id === 'modalGrill') return sendGrillWhatsApp();
            return sendCuisineWhatsApp();
        });
    });

    document.querySelectorAll('.modal-complete-btn').forEach(b => {
        b.addEventListener('click', () => {
            // placeholder: currently open whatsapp to same message; replace with POST to /orders later
            document.querySelector('.modal-whatsapp-btn').click();
        });
    });

    // WhatsApp message builders
    function sendCuisineWhatsApp(){
        const name = document.getElementById('cuisineItemName').textContent;
        const qty = Number(document.getElementById('cuisineQtyInput').value || 1);
        const addons = [];
        document.querySelectorAll('#cuisineAddonsList .addon-qty').forEach(i => {
            const q = Number(i.value || 0);
            if(q > 0){
                const aName = i.closest('.addon-row').querySelector('.addon-name').textContent.trim();
                addons.push({name: aName, qty: q, price: Number(i.dataset.price || 0)});
            }
        });
        const prefs = [];
        if(document.getElementById('cuisinePrefNoOnion').checked) prefs.push('No onion');
        if(document.getElementById('cuisinePrefNoCrayfish').checked) prefs.push('No crayfish');

        let msg = `Order from De Manchys Lounge%0AItem: ${name}%0AQty: ${qty}%0A`;
        if(addons.length){
            msg += `Add-ons:%0A`;
            addons.forEach(a => msg += ` - ${a.name} x${a.qty} (+${formatPrice(a.price * a.qty)})%0A`);
        }
        if(prefs.length) msg += `Preferences: ${prefs.join(', ')}%0A`;
        const total = document.getElementById('cuisineTotalPrice').textContent;
        msg += `Total: ${total}%0A`;
        const phone = '<YOUR_WHATSAPP_NUMBER_WITH_COUNTRYCODE>';
        window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`, '_blank');
    }

    function sendDrinksWhatsApp(){
        const name = document.getElementById('drinksItemName').textContent;
        const qty = Number(document.getElementById('drinksQtyInput').value || 1);
        const total = document.getElementById('drinksTotalPrice').textContent;
        let msg = `Order from De Manchys Lounge%0AItem: ${name}%0AQty: ${qty}%0ATotal: ${total}%0A`;
        const phone = '<YOUR_WHATSAPP_NUMBER_WITH_COUNTRYCODE>';
        window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`, '_blank');
    }

    function sendGrillWhatsApp(){
        const name = document.getElementById('grillItemName').textContent;
        const qty = Number(document.getElementById('grillQtyInput').value || 1);
        const addons = [];
        document.querySelectorAll('#grillAddonsList .addon-qty').forEach(i => {
            const q = Number(i.value || 0);
            if(q>0){
                const aName = i.closest('.addon-row').querySelector('.addon-name').textContent.trim();
                addons.push({name: aName, qty: q, price: Number(i.dataset.price || 0)});
            }
        });
        const prefs = [];
        if(document.getElementById('grillPrefNoOnion').checked) prefs.push('No onion');
        if(document.getElementById('grillPrefNoVeg').checked) prefs.push('No vegetables');

        let msg = `Order from De Manchys Lounge%0AItem: ${name}%0AQty: ${qty}%0A`;
        if(addons.length){
            msg += `Add-ons:%0A`;
            addons.forEach(a => msg += ` - ${a.name} x${a.qty} (+${formatPrice(a.price * a.qty)})%0A`);
        }
        if(prefs.length) msg += `Preferences: ${prefs.join(', ')}%0A`;
        const total = document.getElementById('grillTotalPrice').textContent;
        msg += `Total: ${total}%0A`;
        const phone = '<YOUR_WHATSAPP_NUMBER_WITH_COUNTRYCODE>';
        window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`, '_blank');
    }

    // When modals hide, clear their addon inputs to avoid stale state
    ['modalCuisine','modalDrinks','modalGrill'].forEach(id => {
        document.getElementById(id).addEventListener('hidden.bs.modal', () => {
            // reset stored objects & addon inputs
            window._cuisine = null; window._drinks = null; window._grill = null;
            // clear addon lists
            if(document.getElementById('cuisineAddonsList')) document.getElementById('cuisineAddonsList').innerHTML = '';
            if(document.getElementById('grillAddonsList')) document.getElementById('grillAddonsList').innerHTML = '';
        });
    });

});
</script>
@endpush

@endsection
