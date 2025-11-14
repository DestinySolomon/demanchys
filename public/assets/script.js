// Carousel Initialization
  document.addEventListener("DOMContentLoaded", function () {
    const loungeCarousel = document.querySelector("#loungeCarousel");
    const carousel = new bootstrap.Carousel(loungeCarousel, {
      interval: 3000,  // Change every 3 seconds
      ride: "carousel", // Auto-starts
      pause: false,     // Keeps running even on hover (optional)
      wrap: true        // Loops back to first slide
    });
  });

  // MENU PAGE INTERACTIONS
   
    // ------------------------------
    // Meal data (17 items)
    // ------------------------------
    const meals = [
      {
        id:1,
        name:"Melon Soup (Egusi Soup)",
        desc:"A rich West African soup made from blended melon seeds, spinach, assorted meats, and aromatic spices.",
        price:4000,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/melon_soup.jpg",
        variations:["Beef","Goat Meat","Chicken","Fish"],
        addons:["Pounded yam","Semovita","Eba","Wheat","Fufu"]
      },
      {
        id:2,
        name:"Vegetable Soup (Edikang Ikong)",
        desc:"A wholesome mix of fluted pumpkin leaves and waterleaf cooked with palm oil, stockfish, and assorted meats.",
        price:5000,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/vegetable-soup.jpg",
        variations:["Beef","Goat Meat","Fish","Chicken"],
        addons:["Semovita","Wheat","Fufu"]
      },
      {
        id:3,
        name:"Afang Soup",
        desc:"A thick green vegetable soup made with afang leaves (wild spinach) and waterleaf, simmered with seafood and assorted meats.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/afang.jpg",
        variations:["Goat Meat","Chicken","Seafood"],
        addons:["Semovita","Eba","Fufu"]
      },
      {
        id:4,
        name:"Editan Soup",
        desc:"A rich Calabar delicacy made from Editan leaves, waterleaf, and assorted meats for a slightly bitter yet flavorful taste.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/editan-soup.jpg",
        variations:["Beef","Goat Meat","Seafood"],
        addons:["Semovita","Wheat","Fufu"]
      },
      {
        id:5,
        name:"Bitterleaf Soup (Ofe Onugbu)",
        desc:"A hearty soup cooked with washed bitterleaf, assorted meats, and dried fish.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/bitterleaf-soup.jpg",
        variations:["Beef","Goat Meat","Fish"],
        addons:["Pounded yam","Semovita","Fufu"]
      },
      {
        id:6,
        name:"Atama Soup",
        desc:"A palm-fruit based soup blended with atama leaves, seafood, and assorted meats for a smoky, earthy flavor.",
        price:5500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/atama-soup.jpg",
        variations:["Goat Meat","Seafood"],
        addons:["Pounded yam","Starch","Fufu","Semovita"]
      },
      {
        id:7,
        name:"White Soup (Nsala)",
        desc:"A light, spicy soup made without palm oil, often prepared with catfish or chicken and flavored with utazi leaves.",
        price:5500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/white-soup.jpg",
        variations:["Catfish","Chicken","Goat Meat"],
        addons:["Semovita","Eba","Fufu","Pounded yam"]
      },
      {
        id:8,
        name:"Okra Soup",
        desc:"A deliciously slimy soup made with okra, palm oil, fish, and assorted meats.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/okra-soup.jpg",
        variations:["Fresh Fish","Beef","Goat Meat"],
        addons:["Eba","Fufu","Pounded yam","Semovita"]
      },
      {
        id:9,
        name:"Atama Soup with Waterleaf",
        desc:"A flavorful soup made with atama leaves and waterleaf, cooked in palm oil with assorted meats and fish.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/atama-2.jpg",
        variations:["Beef","Goat Meat","Seafood"],
        addons:["Pounded yam","Fufu","Semovita"]
      },
    //   {
    //     id:10,
    //     name:"Mushroom Soup",
    //     desc:"A hearty blend of mushrooms simmered with okra.",
    //     price:5000,
    //     availability:"Fridays",
    //     type:"Veg",
    //     img:"https://source.unsplash.com/600x400/?mushroom-soup",
    //     variations:["Goat Meat","Chicken","Beef"],
    //     addons:["Semovita","Fufu","Eba"]
    //   },
      {
        id:11,
        name:"Fisherman Soup",
        desc:"A spicy seafood soup bursting with fresh fish, crab, prawn, and periwinkle cooked in rich herbs and palm oil.",
        price:12000,
        availability:"On Request",
        type:"Non-Veg",
        img:"assets/fisherman-soup.jpg",
        variations:["Regular","Deluxe"],
        addons:["Pounded yam","Rice","Fufu","Semovita"]
      },
      {
        id:12,
        name:"Jollof Rice",
        desc:"Classic West African dish made with long-grain rice simmered in tomato sauce, bell peppers, and spices.",
        price:4500,
        availability:"Daily",
        type:"Veg/Non-Veg",
        img:"assets/jollof-rice.jpg",
        variations:["Plain","With Chicken","With Fish","With Beef"],
        addons:["Fried plantain","Coleslaw"]
      },
      {
        id:13,
        name:"Fried Rice",
        desc:"Stir-fried rice with mixed vegetables, eggs, and special seasoning for a flavorful taste.",
        price:5000,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/fried-rice.jpg",
        variations:["With Chicken","With Beef","With Seafood"],
        addons:["Fried plantain","Coleslaw"]
      },
      {
        id:14,
        name:"White Rice and Stew",
        desc:"Steamed white rice served with rich tomato stew made with beef or chicken.",
        price:4500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/white-rice-and-stew.jpg",
        variations:["With Beef","With Chicken","With Fish"],
        addons:["Fried plantain","Coleslaw"]
      },
      {
        id:15,
        name:"Jambalaya Rice",
        desc:"A flavorful fusion rice with spicy sausages, shrimp, chicken, and vegetables cooked in seasoned broth.",
        price:8000,
        availability:"On Request",
        type:"Non-Veg",
        img:"assets/jambalaya-rice.jpg",
        variations:["Chicken & Shrimp","Sausage Mix"],
        addons:["Coleslaw","Fried plantain"]
      },
      {
        id:16,
        name:"Pineapple Fried Rice",
        desc:"Fragrant rice stir-fried with fresh pineapple chunks, veggies, and light spices for a tropical flavor.",
        price:10000,
        availability:"On Request",
        type:"Veg/Non-Veg",
        img:"assets/pineapple-rice.jpg",
        variations:["Veg","With Chicken","With Shrimp"],
        addons:["Fried plantain","Coleslaw"]
      },
      {
        id:17,
        name:"Pepper Soup Rice",
        desc:"Steamed rice infused with spicy Nigerian pepper soup broth, served with assorted meat or fish.",
        price:5500,
        availability:"Daily",
        type:"Non-Veg",
        img:"assets/pepper-soup-rice.jpg",
        variations:["Goat Meat","Chicken","Fish"],
        addons:["Fried plantain","Coleslaw"]
      }
    ];

    // ------------------------------
    // Cart state
    // ------------------------------
    let cart = {
      items: [], // array of { mealId, mealName, qty:1, addons: [{name, qty}] }
      totalCount: 0
    };

    // Helpers
    function formatPrice(n){
      if(typeof n === 'number') return "₦" + n.toLocaleString();
      return n;
    }

    // Render cards
    const menuGrid = document.getElementById("menuGrid");
    function renderMenu(){
      menuGrid.innerHTML = "";
      meals.forEach(meal=>{
        const col = document.createElement("div");
        col.className = "col-md-6 col-lg-4";
        col.innerHTML = `
          <div class="card menu-card mb-3">
            <img src="${meal.img}" class="card-img-top" alt="${meal.name}">
            <div class="card-body d-flex flex-column">
              <div>
                <div class="meal-title">${meal.name}</div>
                <div class="meal-meta">${meal.type} • ${meal.availability} • ${formatPrice(meal.price)}</div>
                <p class="mb-0 text-light small">${meal.desc}</p>
              </div>

              <div class="card-footer-actions mt-3">
                <button class="btn btn-order w-50" data-meal="${meal.id}" onclick="orderNow(${meal.id})">Order Now</button>
                <button class="btn btn-custom w-50" data-bs-toggle="modal" data-bs-target="#customizeModal" onclick="openCustomize(${meal.id})">Customize Meal</button>
              </div>
            </div>
          </div>
        `;
        menuGrid.appendChild(col);
      });
    }

    // Initialize
    renderMenu();
    updateCartCounter();

    // ------------------------------
    // Modal logic
    // ------------------------------
    let activeMeal = null;
    const modalMealTitle = document.getElementById("modalMealTitle");
    const modalMealDesc = document.getElementById("modalMealDesc");
    const modalAddonsContainer = document.getElementById("modalAddons");
    const addToOrderBtn = document.getElementById("addToOrderBtn");

    function openCustomize(mealId){
      activeMeal = meals.find(m=>m.id === mealId);
      if(!activeMeal) return;

      modalMealTitle.textContent = activeMeal.name;
      modalMealDesc.textContent = `${activeMeal.desc} — Price: ${formatPrice(activeMeal.price)}.`;

      // Build add-on list combining variations (meats/fish/chicken) and other addons
      // We'll present "Variations" first (each with qty control) and then "Add-Ons"
      const list = [];

      if(activeMeal.variations && activeMeal.variations.length){
        list.push({ groupTitle: "Proteins / Variations", entries: activeMeal.variations.map(v => ({ name: v })) });
      }
      if(activeMeal.addons && activeMeal.addons.length){
        list.push({ groupTitle: "Sides / Add-Ons", entries: activeMeal.addons.map(a => ({ name: a })) });
      }

      // Create DOM
      modalAddonsContainer.innerHTML = "";
      list.forEach((group, gIndex)=>{
        const groupEl = document.createElement("div");
        groupEl.className = "mb-3";
        groupEl.innerHTML = `<h6 class="mb-2 text-light">${group.groupTitle}</h6>`;
        group.entries.forEach((entry, idx)=>{
          const idKey = `addon-${gIndex}-${idx}`;
          // initial quantity 0
          const itemHtml = document.createElement("div");
          itemHtml.className = "addon-item";
          itemHtml.innerHTML = `
            <div class="addon-name"><strong>${entry.name}</strong></div>
            <div class="addon-controls">
              <button type="button" class="decr btn-decr" data-id="${idKey}">−</button>
              <span id="${idKey}" class="mx-2">0</span>
              <button type="button" class="incr btn-incr" data-id="${idKey}">+</button>
            </div>
          `;
          modalAddonsContainer.appendChild(itemHtml);
        });
      });

      // store a data object to hold counts for this modal session
      modalAddonsContainer._counts = {}; // map idKey -> count

      // wire up increment/decrement
      modalAddonsContainer.querySelectorAll(".btn-incr").forEach(btn=>{
        btn.addEventListener("click", (e)=>{
          const id = e.currentTarget.getAttribute("data-id");
          const el = document.getElementById(id);
          modalAddonsContainer._counts[id] = (modalAddonsContainer._counts[id] || 0) + 1;
          el.textContent = modalAddonsContainer._counts[id];
        });
      });
      modalAddonsContainer.querySelectorAll(".btn-decr").forEach(btn=>{
        btn.addEventListener("click", (e)=>{
          const id = e.currentTarget.getAttribute("data-id");
          const el = document.getElementById(id);
          modalAddonsContainer._counts[id] = Math.max((modalAddonsContainer._counts[id]||0) - 1, 0);
          el.textContent = modalAddonsContainer._counts[id];
        });
      });

      // Show the modal (Bootstrap takes care of this when button clicked)
    }

    // ------------------------------
    // Add to order (simulate & update cart)
    // ------------------------------
    function collectModalSelection(){
      // Build addons selection array from modal DOM and counts
      const selections = [];
      const countsObj = modalAddonsContainer._counts || {};
      // find all span ids
      modalAddonsContainer.querySelectorAll("span[id^='addon-']").forEach(span=>{
        const id = span.id;
        const count = countsObj[id] || 0;
        if(count > 0){
          // get name — sibling previous element contains name
          const parent = span.closest('.addon-item');
          const name = parent.querySelector('.addon-name').textContent.trim();
          selections.push({ name, qty: count });
        }
      });
      return selections;
    }

    addToOrderBtn.addEventListener("click", ()=>{
      if(!activeMeal) return;
      const selections = collectModalSelection();

      // create cart item
      const cartItem = {
        mealId: activeMeal.id,
        name: activeMeal.name,
        qty: 1,
        price: activeMeal.price,
        addons: selections
      };
      cart.items.push(cartItem);
      cart.totalCount += 1;
      updateCartCounter();

      // close modal
      const modalEl = document.getElementById('customizeModal');
      const bsModal = bootstrap.Modal.getInstance(modalEl);
      if(bsModal) bsModal.hide();

      // show toast with summary
      showToast(`${activeMeal.name} added to cart.` , selections.length ? `Add-ons: ${selections.map(s=>s.name + " x"+s.qty).join(", ")}` : "No add-ons selected");
    });

    // Order Now button — quick add with no customizations
    function orderNow(mealId){
      const meal = meals.find(m=>m.id === mealId);
      if(!meal) return;
      const cartItem = {
        mealId: meal.id,
        name: meal.name,
        qty: 1,
        price: meal.price,
        addons: []
      };
      cart.items.push(cartItem);
      cart.totalCount += 1;
      updateCartCounter();
      showToast(`${meal.name} added to cart.`, "Quick order");
    }

    // Update cart counter UI
    function updateCartCounter(){
      const el = document.getElementById("cartCounter");
      el.textContent = cart.totalCount;
    }

    // Toast helper
    function showToast(title, subtitle){
      const id = 't' + Date.now();
      const toastHtml = document.createElement('div');
      toastHtml.className = 'toast align-items-center text-bg-light border-0';
      toastHtml.setAttribute('role','alert');
      toastHtml.setAttribute('aria-live','assertive');
      toastHtml.setAttribute('aria-atomic','true');
      toastHtml.innerHTML = `
        <div class="d-flex">
          <div class="toast-body">
            <strong>${title}</strong><div class="small text-light">${subtitle}</div>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      `;
      document.getElementById('toastContainer').appendChild(toastHtml);
      const bsToast = new bootstrap.Toast(toastHtml, { delay: 3000 });
      bsToast.show();
      // remove after hidden
      toastHtml.addEventListener('hidden.bs.toast', ()=> toastHtml.remove());
    }

    // For cart button: open a simple summary (simulate)
    document.getElementById('cartBtn').addEventListener('click', ()=>{
      // build quick modal-like box using alert for now
      if(cart.items.length === 0){
        showToast('Cart is empty', 'Add items to your order');
        return;
      }
      const lines = cart.items.map((it, idx)=> `${idx+1}. ${it.name} ${it.addons.length ? "(" + it.addons.map(a=>a.name + " x"+a.qty).join(", ") + ")" : ""}` );
      // Show as toast (since no cart page)
      showToast('Cart Summary', lines.join(" • "));
    });

    // End of script
 