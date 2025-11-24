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

    // try to get current user info from body dataset (optional)
    const currentUser = {
        name: document.body.dataset.userName || 'Guest',
        phone: document.body.dataset.userPhone || 'Unknown'
    };

    // universal fetch endpoint for item data
    async function fetchItem(id) {
        const res = await fetch(`/menu/item/${id}`);
        if (!res.ok) throw new Error('Item not found');
        return await res.json();
    }

    // universal rendering helpers
    function createAddonRow(addon, prefix) {
        // prefix: 'cuisine' or 'grill'
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

    // ORDER NOW buttons (quick whatsapp) - full formatted order message (delivery type unspecified)
    document.querySelectorAll('.order-now-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const name = btn.dataset.name;
            const price = Number(btn.dataset.price || 0);
            const qty = 1;
            const total = price * qty;
            
            let msg = `New Order\n`;
            msg += `Item: ${name}\n`;
            msg += `Quantity: ${qty}\n`;
            msg += `Add-ons: None\n`;
            msg += `Preferences: None\n`;
            msg += `Total: ${formatPrice(total)}\n`;
            msg += `Delivery Type: Unspecified\n`;
            msg += `Customer: ${currentUser.name} - ${currentUser.phone}`;
            
            const phone = '<YOUR_WHATSAPP_NUMBER_WITH_COUNTRYCODE>'; // replace with admin number
            window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(msg)}`, '_blank');
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

    // ... rest of your code would continue here
});