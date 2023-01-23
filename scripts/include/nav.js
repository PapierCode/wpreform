document.addEventListener( 'DOMContentLoaded', () => {

    /*=============================
    =            Utile            =
    =============================*/
    
    // conversion pixels en rem
    const rem = ( size, base = 16 ) => size / base + 'rem';
    
    // enfant(s) d'un même parent
    const getSiblings = ( target ) => {
        var siblings = []; 
        var sibling = target.parentNode.firstChild;
        while (sibling) {
            if ( sibling.nodeType === 1 && sibling !== target ) { siblings.push(sibling); }
            sibling = sibling.nextSibling;
        }
        return siblings;
    };
    
    
    /*=====  FIN Utile  =====*/
    
    /*=================================
    =            Fonctions            =
    =================================*/
    
    const subListAttrHeight = ( subList ) => {
        subList.style.maxHeight = 'none'; // annule les css (max-height:0)
        subList.setAttribute( 'data-height', rem(subList.offsetHeight) );
        subList.style.maxHeight = 0;
    };
    
    /*----------  Visibilité du bouton "burger"  ----------*/
    
    const btnBurgerVisibility = () => {
        return getComputedStyle( btnBurgerBox ).display == 'none' ? false : true;
    };
    
    
    /*----------  Sous-menu ouvrir/fermer  ----------*/
    
    const navSubOpen = ( parent, btn, subList, siblings ) => {
    
        // autre élémént ouvert
        let open = siblings.find( ( sibling ) => { return sibling.classList.contains('is-open'); } );
        if ( open ) {
            openBtn = open.firstChild;
            openSubList = openBtn.nextSibling;
            navSubClose( open, openBtn, openSubList );
        }
    
        subList.ontransitionend = null; // ajouté à la fermeture
        subList.style.visibility = 'visible';
    
        // option valeur transition height gérée en JS
        if ( navArgs.heightAnimation.small && btnBurgerIsVisible || navArgs.heightAnimation.full && !btnBurgerIsVisible ) {
            subList.style.maxHeight = subList.dataset.height;
        }
    
        btn.setAttribute( 'aria-expanded', 'true' );
        parent.classList.add('is-open');
    
    };
    
    const navSubClose = ( parent, btn, subList ) => {
    
        // option valeur transition height gérée en JS
        if ( navArgs.heightAnimation.small && btnBurgerIsVisible || navArgs.heightAnimation.full && !btnBurgerIsVisible ) {
            subList.style.maxHeight =  0;
        }
    
        // attendre la fin de la transition CSS
        subList.ontransitionend = () => {				
            subList.style.visibility = 'hidden';
            btn.setAttribute( 'aria-expanded', 'false' );
        };
    
        parent.classList.remove('is-open');
    
    };
    
    const navSubToggle = ( parent, btn, subList, siblings ) => {
    
        if ( parent.classList.contains('is-open') ) { navSubClose( parent, btn, subList ); }
        else { navSubOpen( parent, btn, subList, siblings ); }
    
    };
    
    
    /*----------  Menu ouvrir/fermer  ----------*/
    
    const navToggle = () => {
    
        if ( !navIsOpen ) { // ouvrir
    
            nav.ontransitionend = null; // ajouté à la fermeture
    
            nav.style.visibility = 'visible';	
            document.addEventListener( 'keydown', navKeyDown );
            html.classList.add('h-nav-is-open');
    
            btnBurger.setAttribute('aria-expanded','true');	
            nav.setAttribute('aria-hidden', 'false');
            navIsOpen = true;
    
        } else { // fermer
    
            if ( nav.ontransitionend == null ) {
    
                nav.ontransitionend = () => {
    
                    nav.style.visibility = 'hidden'; 
                    document.removeEventListener( 'keydown', navKeyDown );		
                    btnBurger.setAttribute('aria-expanded','false');	
                    nav.setAttribute('aria-hidden','true');
                    navIsOpen = false;
    
                };
    
                html.classList.remove('h-nav-is-open');	
    
            }
            
        }
    
    };
    
    // zone hors menu ouvert
    const navOverlay = ( event ) => { if ( event.target == nav ) { navToggle(); } };
    // touche échap
    const navKeyDown = ( event ) => { if ( event.key == 'Escape' ) { navToggle(); } };
    
    
    /*----------  Mise à jour menu  ----------*/
    
    const navUpdate = () => {
    
        if ( liParents.length > 0 ) {
    
            /*----------  Sous-menus  ----------*/
            
            liParents.forEach( ( parent ) => {
                
                let btn = parent.firstChild;
                let subList = btn.nextSibling;  
                let siblings = getSiblings( parent );
    
                // ferme le sous-menu si ouvert
                if ( parent.classList.contains( 'is-open' ) ) { navSubClose( parent, btn, subList ); }
    
                btn.onclick = () => { navSubToggle( parent, btn, subList, siblings ); };
                
                if ( !btnBurgerIsVisible ) { // menu visible
    
                    if ( !navArgs.heightAnimation.full ) { subList.style.removeProperty( 'max-height' ); }
    
                    parent.onmouseenter = () => {
                        btn.onclick = null;
                        navSubOpen( parent, btn, subList, siblings );
                    };
                    parent.onmouseleave = () => {
                        // TODO timer
                        btn.onclick = () => { navSubToggle( parent, btn, subList, siblings ); };
                        navSubClose( parent, btn, subList );
                    };
    
                } else { // menu caché
    
                    if ( navArgs.heightAnimation.small ) { subListAttrHeight( subList ); }
    
                    // ouverture menu actif
                    if ( parent.classList.contains('is-active') ) { navSubOpen( parent, btn, subList, siblings ); }
    
                    parent.onmouseenter = null;
                    parent.onmouseleave = null;
    
                }
    
            });
    
        } // FIN liParents
    
    
        /*----------  Menu visible/caché  ----------*/    
    
        if ( btnBurgerIsVisible ) {
    
            nav.setAttribute('aria-labelledby','#header-nav-btn');
            nav.setAttribute('aria-hidden','true');
            nav.style.visibility = 'hidden';
    
            btnBurger.onclick = () => { navToggle(); };
            nav.onclick = (event) => { navOverlay(event); }; 
    
        } else {
    
            btnBurger.onclick = null;
            nav.onclick = null; 
            nav.ontransitionend = null;
    
            btnBurger.setAttribute( 'aria-expanded', 'false' );
            nav.removeAttribute('aria-labelledby');
            nav.removeAttribute('aria-hidden');
            nav.removeAttribute('style');
    
            html.classList.remove('h-nav-is-open');
            navIsOpen = false;
    
        }
    
    };
    
    
    /*=====  FIN Fonctions  =====*/
    
    /*====================================================
    =            Variables/constantes de base            =
    ====================================================*/
    
    const html = document.querySelector( 'html' );
    
    const btnBurgerBox = document.querySelector( '.h-nav-btn-box' );
    const btnBurger = btnBurgerBox.querySelector( '.h-nav-btn' );
    
    const nav = btnBurgerBox.nextSibling;
    const liParents = nav.querySelectorAll( '.h-p-nav-item--l1.is-parent' );
    
    let btnBurgerIsVisible = btnBurgerVisibility();
    let navIsOpen = false;
    
    // un timer pour prévenir la multiplication de l'événement
    let resizeTimer = null;

    
    /*=====  FIN Variables/constantes de base  =====*/
    
    /*==================================
    =            Responsive            =
    ==================================*/
    
    window.addEventListener( 'resize', () => {
    
        clearTimeout(resizeTimer);
    
        resizeTimer = setTimeout( () => {
    
            let currentBtnBurgerVisibility = btnBurgerVisibility();
    
            if ( btnBurgerIsVisible != currentBtnBurgerVisibility ) {
                btnBurgerIsVisible = currentBtnBurgerVisibility;
                navUpdate();
            }
    
        }, 250 );
    
    } );
    
    
    /*=====  FIN Responsive  =====*/
    
    /*=============================
    =            Start            =
    =============================*/
    
    if ( liParents.length > 0 ) {
    
        liParents.forEach( ( parent, index ) => {
    
            let btn = parent.firstChild;
            btn.setAttribute( 'id', 'h-nav-btn-submenu-' + index );
            btn.setAttribute( 'aria-controls', 'h-nav-submenu-' + index );
            btn.setAttribute( 'aria-expanded', 'false' );
    
            let subList = btn.nextSibling;
            subList.setAttribute( 'id', 'h-nav-submenu-' + index );
            subList.setAttribute( 'aria-labelledby', 'h-nav-btn-submenu-' + index );
            subList.style.visibility = 'hidden';
    
            if ( navArgs.heightAnimation.small && btnBurgerIsVisible || navArgs.heightAnimation.full && !btnBurgerIsVisible ) {
                subListAttrHeight( subList );
            }
    
        });
    
    }
    
    navUpdate();
    
    
    /*=====  FIN Start  =====*/
    
    
    } ); // FIN DOMContentLoaded