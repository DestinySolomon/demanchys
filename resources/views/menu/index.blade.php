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



        <div class="delivery-type">
    <label for="cuisineDeliveryType">Delivery Type</label>
    <select id="cuisineDeliveryType">
        <option value="Eat In">Eat In</option>
        <option value="Takeaway">Takeaway</option>
        <option value="Home Delivery">Home Delivery</option>
    </select>
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
            <div class="delivery-type">
    <label for="cuisineDeliveryType">Delivery Type</label>
    <select id="cuisineDeliveryType">
        <option value="Eat In">Drink In</option>
        <option value="Takeaway">Takeaway</option>
        <option value="Home Delivery">Home Delivery</option>
    </select>
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


                 <div class="delivery-type">
                         <label for="cuisineDeliveryType">Delivery Type</label>
                      <select id="cuisineDeliveryType">
               <option value="Eat In">Eat In</option>
                 <option value="Takeaway">Takeaway</option>
               <option value="Home Delivery">Home Delivery</option>
         </select>
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
    function formatPrice(n) {
        return '₦' + new Intl.NumberFormat().format(n);
    }

    // parse a displayed price like "₦3,500" -> number 3500
    function parsePrice(display) {
        if (!display) return 0;
        return Number(String(display).replace(/[^0-9.]/g, '') || 0);
    }

    // universal fetch endpoint for item data
    async function fetchItem(id) {
        const res = await fetch(`/menu/item/${id}`);
        if (!res.ok) throw new Error('Item not found');
        return await res.json();
    }

    // universal rendering helpers
    function createAddonRow(addon, prefix) {
        const wrapper = document.createElement('div');
        wrapper.className = 'addon-row d-flex justify-content-between align-items-center';
        wrapper.innerHTML = `
            <div>
                <div class="fw-semibold addon-name">${addon.name}</div>
                <div class="small-muted">+ ${formatPrice(addon.price)}</div>
            </div>
            <div class="addon-controls d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-outline-light addon-minus me-2" data-id="${addon.id}" data-price="${addon.price}">-</button>
                <input type="text" value="0" class="addon-qty form-control form-control-sm text-center" data-id="${addon.id}" data-price="${addon.price}" style="width:56px;">
                <button type="button" class="btn btn-sm btn-outline-light addon-plus ms-2" data-id="${addon.id}" data-price="${addon.price}">+</button>
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
                if (category.includes('drink')) {
                    populateDrinksModal(item);
                    new bootstrap.Modal(document.getElementById('modalDrinks')).show();
                } else if (category.includes('grill') || category.includes('grilled')) {
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

    // ORDER NOW buttons - simple redirect to checkout
    document.querySelectorAll('.order-now-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const itemId = btn.dataset.id;
            // Simple form submission - Laravel will handle authentication
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/checkout';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
            }
            
            // Add item ID
            const itemInput = document.createElement('input');
            itemInput.type = 'hidden';
            itemInput.name = 'item_id';
            itemInput.value = itemId;
            form.appendChild(itemInput);
            
            document.body.appendChild(form);
            form.submit();
        });
    });

    // ---------------------------
    // Populate each modal type
    // ---------------------------

    // Cuisine modal
    function populateCuisineModal(item) {
        // set base fields
        const nameEl = document.getElementById('cuisineItemName');
        const priceEl = document.getElementById('cuisineItemPrice');
        const descEl = document.getElementById('cuisineItemDesc');
        const imgEl = document.getElementById('cuisineItemImage');

        if (nameEl) nameEl.textContent = item.name;
        if (priceEl) priceEl.textContent = formatPrice(item.price);
        if (descEl) descEl.textContent = item.description || '';
        if (imgEl) imgEl.innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        // reset quantities and prefs
        const qtyInput = document.getElementById('cuisineQtyInput');
        if (qtyInput) qtyInput.value = 1;
        if (document.getElementById('cuisinePrefNoOnion')) document.getElementById('cuisinePrefNoOnion').checked = false;
        if (document.getElementById('cuisinePrefNoCrayfish')) document.getElementById('cuisinePrefNoCrayfish').checked = false;

        // render addons (plus/minus)
        const list = document.getElementById('cuisineAddonsList');
        if (list) {
            list.innerHTML = '';
            const addons = item.addons || [];
            if (addons.length === 0) {
                list.innerHTML = '<div class="small-muted">No add-ons available</div>';
            } else {
                addons.forEach(a => list.appendChild(createAddonRow(a, 'cuisine')));
            }
            // attach addon plus/minus logic for cuisine
            attachAddonControls(list);
        }

        // set stored object
        window._cuisine = {
            id: item.id,
            name: item.name,
            category: item.category || 'cuisine',
            base_price: Number(item.price || 0)
        };
        recalcCuisineTotal();
    }

    function attachAddonControls(listEl) {
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
            inp.addEventListener('input', () => {
                inp.value = Math.max(0, Number(inp.value || 0));
                recalcAllTotals();
            });
        });
    }

    // Drinks modal
    function populateDrinksModal(item) {
        const nameEl = document.getElementById('drinksItemName');
        const priceEl = document.getElementById('drinksItemPrice');
        const descEl = document.getElementById('drinksItemDesc');
        const imgEl = document.getElementById('drinksItemImage');

        if (nameEl) nameEl.textContent = item.name;
        if (priceEl) priceEl.textContent = formatPrice(item.price);
        if (descEl) descEl.textContent = item.description || '';
        if (imgEl) imgEl.innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        const qtyInput = document.getElementById('drinksQtyInput');
        if (qtyInput) qtyInput.value = 1;
        window._drinks = {
            id: item.id,
            name: item.name,
            category: item.category || 'drinks',
            base_price: Number(item.price || 0)
        };
        recalcDrinksTotal();
    }

    // Grill modal
    function populateGrillModal(item) {
        const nameEl = document.getElementById('grillItemName');
        const priceEl = document.getElementById('grillItemPrice');
        const descEl = document.getElementById('grillItemDesc');
        const imgEl = document.getElementById('grillItemImage');

        if (nameEl) nameEl.textContent = item.name;
        if (priceEl) priceEl.textContent = formatPrice(item.price);
        if (descEl) descEl.textContent = item.description || '';
        if (imgEl) imgEl.innerHTML = item.image ? `<img src="/storage/${item.image}" style="max-width:120px;border-radius:8px;" />` : '';

        const qtyInput = document.getElementById('grillQtyInput');
        if (qtyInput) qtyInput.value = 1;
        if (document.getElementById('grillPrefNoOnion')) document.getElementById('grillPrefNoOnion').checked = false;
        if (document.getElementById('grillPrefNoVeg')) document.getElementById('grillPrefNoVeg').checked = false;

        const list = document.getElementById('grillAddonsList');
        if (list) {
            list.innerHTML = '';
            const addons = item.addons || [];
            if (addons.length === 0) {
                list.innerHTML = '<div class="small-muted">No add-ons available</div>';
            } else {
                addons.forEach(a => list.appendChild(createAddonRow(a, 'grill')));
            }
            attachAddonControls(list);
        }

        window._grill = {
            id: item.id,
            name: item.name,
            category: item.category || 'grill',
            base_price: Number(item.price || 0)
        };
        recalcGrillTotal();
    }

    // ---------------------------
    // Quantity controls and recalc
    // ---------------------------

    // cuisine qty buttons
    if (document.getElementById('cuisineQtyPlus')) {
        document.getElementById('cuisineQtyPlus').addEventListener('click', () => {
            const el = document.getElementById('cuisineQtyInput');
            el.value = Math.max(1, Number(el.value) + 1);
            recalcCuisineTotal();
        });
    }
    
    if (document.getElementById('cuisineQtyMinus')) {
        document.getElementById('cuisineQtyMinus').addEventListener('click', () => {
            const el = document.getElementById('cuisineQtyInput');
            el.value = Math.max(1, Number(el.value) - 1);
            recalcCuisineTotal();
        });
    }
    
    if (document.getElementById('cuisineQtyInput')) {
        document.getElementById('cuisineQtyInput').addEventListener('input', () => {
            document.getElementById('cuisineQtyInput').value = Math.max(1, Number(document.getElementById('cuisineQtyInput').value || 1));
            recalcCuisineTotal();
        });
    }

    function recalcCuisineTotal() {
        const cur = window._cuisine;
        if (!cur) return;
        const qty = Number(document.getElementById('cuisineQtyInput').value || 1);
        let addonsTotal = 0;
        document.querySelectorAll('#cuisineAddonsList .addon-qty').forEach(i => {
            addonsTotal += Number(i.value || 0) * Number(i.dataset.price || 0);
        });
        const total = (cur.base_price + addonsTotal) * qty;
        if (document.getElementById('cuisineTotalPrice')) {
            document.getElementById('cuisineTotalPrice').textContent = formatPrice(total);
        }
    }

    // drinks qty
    if (document.getElementById('drinksQtyPlus')) {
        document.getElementById('drinksQtyPlus').addEventListener('click', () => {
            const el = document.getElementById('drinksQtyInput');
            el.value = Math.max(1, Number(el.value) + 1);
            recalcDrinksTotal();
        });
    }
    
    if (document.getElementById('drinksQtyMinus')) {
        document.getElementById('drinksQtyMinus').addEventListener('click', () => {
            const el = document.getElementById('drinksQtyInput');
            el.value = Math.max(1, Number(el.value) - 1);
            recalcDrinksTotal();
        });
    }
    
    if (document.getElementById('drinksQtyInput')) {
        document.getElementById('drinksQtyInput').addEventListener('input', () => {
            document.getElementById('drinksQtyInput').value = Math.max(1, Number(document.getElementById('drinksQtyInput').value || 1));
            recalcDrinksTotal();
        });
    }

    function recalcDrinksTotal() {
        const cur = window._drinks;
        if (!cur) return;
        const qty = Number(document.getElementById('drinksQtyInput').value || 1);
        const total = cur.base_price * qty;
        if (document.getElementById('drinksTotalPrice')) {
            document.getElementById('drinksTotalPrice').textContent = formatPrice(total);
        }
    }

    // grill qty
    if (document.getElementById('grillQtyPlus')) {
        document.getElementById('grillQtyPlus').addEventListener('click', () => {
            const el = document.getElementById('grillQtyInput');
            el.value = Math.max(1, Number(el.value) + 1);
            recalcGrillTotal();
        });
    }
    
    if (document.getElementById('grillQtyMinus')) {
        document.getElementById('grillQtyMinus').addEventListener('click', () => {
            const el = document.getElementById('grillQtyInput');
            el.value = Math.max(1, Number(el.value) - 1);
            recalcGrillTotal();
        });
    }
    
    if (document.getElementById('grillQtyInput')) {
        document.getElementById('grillQtyInput').addEventListener('input', () => {
            document.getElementById('grillQtyInput').value = Math.max(1, Number(document.getElementById('grillQtyInput').value || 1));
            recalcGrillTotal();
        });
    }

    function recalcGrillTotal() {
        const cur = window._grill;
        if (!cur) return;
        const qty = Number(document.getElementById('grillQtyInput').value || 1);
        let addonsTotal = 0;
        document.querySelectorAll('#grillAddonsList .addon-qty').forEach(i => {
            addonsTotal += Number(i.value || 0) * Number(i.dataset.price || 0);
        });
        const total = (cur.base_price + addonsTotal) * qty;
        if (document.getElementById('grillTotalPrice')) {
            document.getElementById('grillTotalPrice').textContent = formatPrice(total);
        }
    }

    // Recalc helper used by addon controls
    function recalcAllTotals() {
        recalcCuisineTotal();
        recalcGrillTotal();
        recalcDrinksTotal();
    }

    // Listen to addon qty changes anywhere (delegated) - update totals
    document.addEventListener('input', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('addon-qty')) {
            recalcAllTotals();
        }
    });

    // ---------------------------
    // Modal Complete buttons
    // ---------------------------
    
    // Complete (POST to /checkout)
    document.querySelectorAll('.modal-complete-btn').forEach(b => {
        b.addEventListener('click', () => {
            const visible = document.querySelector('.modal.show');
            if (!visible) return alert('No modal active');

            // build order payload depending on visible modal
            let payload = {
                item_name: '',
                qty: 1,
                total_display: '',
                total_amount: 0,
                addons: [],
                preferences: [],
                category: '',
                delivery_type: 'Unspecified'
            };

            // helper to read delivery radio inside visible modal
            function readDeliveryFromModal(el) {
                if (!el) return 'Unspecified';

                const select =
                    el.querySelector('#cuisineDeliveryType') ||
                    el.querySelector('#drinksDeliveryType') ||
                    el.querySelector('#grillDeliveryType');

                return select ? select.value : 'Unspecified';
            }

            if (visible.id === 'modalDrinks') {
                const name = document.getElementById('drinksItemName').textContent;
                const qty = Number(document.getElementById('drinksQtyInput').value || 1);
                const totalDisplay = document.getElementById('drinksTotalPrice').textContent;
                const totalAmt = parsePrice(totalDisplay);

                payload.item_name = name;
                payload.qty = qty;
                payload.total_display = totalDisplay;
                payload.total_amount = totalAmt;
                payload.addons = [];
                payload.preferences = [];
                payload.delivery_type = readDeliveryFromModal(visible);
                payload.category = (window._drinks && window._drinks.category) || 'drinks';

            } else if (visible.id === 'modalGrill') {
                const name = document.getElementById('grillItemName').textContent;
                const qty = Number(document.getElementById('grillQtyInput').value || 1);
                const totalDisplay = document.getElementById('grillTotalPrice').textContent;
                const totalAmt = parsePrice(totalDisplay);

                payload.item_name = name;
                payload.qty = qty;
                payload.total_display = totalDisplay;
                payload.total_amount = totalAmt;
                payload.addons = [];
                document.querySelectorAll('#grillAddonsList .addon-qty').forEach(i => {
                    const q = Number(i.value || 0);
                    if (q > 0) {
                        const id = i.dataset.id;
                        const price = Number(i.dataset.price || 0);
                        const nameA = i.closest('.addon-row').querySelector('.addon-name').textContent.trim();
                        payload.addons.push({id, name: nameA, qty: q, price: price});
                    }
                });
                if (document.getElementById('grillPrefNoOnion') && document.getElementById('grillPrefNoOnion').checked) payload.preferences.push('No onion');
                if (document.getElementById('grillPrefNoVeg') && document.getElementById('grillPrefNoVeg').checked) payload.preferences.push('No vegetables');
                payload.delivery_type = readDeliveryFromModal(visible);
                payload.category = (window._grill && window._grill.category) || 'grill';

            } else {
                // cuisine
                const name = document.getElementById('cuisineItemName').textContent;
                const qty = Number(document.getElementById('cuisineQtyInput').value || 1);
                const totalDisplay = document.getElementById('cuisineTotalPrice').textContent;
                const totalAmt = parsePrice(totalDisplay);

                payload.item_name = name;
                payload.qty = qty;
                payload.total_display = totalDisplay;
                payload.total_amount = totalAmt;
                payload.addons = [];
                document.querySelectorAll('#cuisineAddonsList .addon-qty').forEach(i => {
                    const q = Number(i.value || 0);
                    if (q > 0) {
                        const id = i.dataset.id;
                        const price = Number(i.dataset.price || 0);
                        const nameA = i.closest('.addon-row').querySelector('.addon-name').textContent.trim();
                        payload.addons.push({id, name: nameA, qty: q, price: price});
                    }
                });
                if (document.getElementById('cuisinePrefNoOnion') && document.getElementById('cuisinePrefNoOnion').checked) payload.preferences.push('No onion');
                if (document.getElementById('cuisinePrefNoCrayfish') && document.getElementById('cuisinePrefNoCrayfish').checked) payload.preferences.push('No crayfish');
                payload.delivery_type = readDeliveryFromModal(visible);
                payload.category = (window._cuisine && window._cuisine.category) || 'cuisine';
            }

            // create and submit form to /checkout with CSRF token
            const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/checkout';

            // hidden inputs
            function addInput(name, value) {
                const i = document.createElement('input');
                i.type = 'hidden';
                i.name = name;
                i.value = (typeof value === 'string') ? value : JSON.stringify(value);
                form.appendChild(i);
            }

            addInput('_token', csrf);
            addInput('item_name', payload.item_name);
            addInput('qty', payload.qty);
            addInput('total_display', payload.total_display);
            addInput('total_amount', payload.total_amount);
            addInput('addons', payload.addons);
            addInput('preferences', payload.preferences);
            addInput('category', payload.category);
            addInput('delivery_type', payload.delivery_type);

            document.body.appendChild(form);
            form.submit();
        });
    });

    // When modals hide, clear their addon inputs to avoid stale state
    ['modalCuisine', 'modalDrinks', 'modalGrill'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('hidden.bs.modal', () => {
            // reset stored objects & addon inputs
            window._cuisine = null;
            window._drinks = null;
            window._grill = null;
            // clear addon lists
            if (document.getElementById('cuisineAddonsList')) document.getElementById('cuisineAddonsList').innerHTML = '';
            if (document.getElementById('grillAddonsList')) document.getElementById('grillAddonsList').innerHTML = '';
        });
    });
});
</script>



@endpush

@endsection
