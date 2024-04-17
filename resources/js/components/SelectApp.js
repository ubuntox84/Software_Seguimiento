

export function select(e) {
   
             function useTrackedPointer() {
        let e = [-1, -1];
        return {
            wasMoved(t) {
            let n = [t.screenX, t.screenY];
            return (e[0] !== n[0] || e[1] !== n[1]) && ((e = n), !0);
            },
            update(t) {
            e = [t.screenX, t.screenY];
            },  };
        }
             let t = e.modelName || "selected",
      n = useTrackedPointer();
      
        return {
        
        data: e.data,
        activeDescendant: null,
        optionCount: null,
        showCurriculas: !1,
        activeIndex: null,
        selectedIndex: 0,
        optionSelected:'',
        options:{},
        init() {
        
           (this.optionCount = this.options.length),
           this.options = this.data,
           this.optionSelected = e.option,
           this.activeIndex=this.options.findIndex(option => option.id === e.option.id),
           this.selectedIndex=this.options.findIndex(option => option.id === e.option.id),
           this.$watch("activeIndex", (e) => {
         
            this.showCurriculas &&
              (null !== this.activeIndex
                ? (this.activeDescendant =
                    this.$refs.listbox.children[this.activeIndex].id)
                : (this.activeDescendant = ""));
          });
      },
      get active() {
        return this.options.findIndex(option => option.id === this.activeIndex);;
      },
      get [t]() {
        return this.options.findIndex(option => option.id === this.selectedIndex);;
      },
      choose(e) {
        (this.selectedIndex = e), (this.showCurriculas = !1);
       this.optionSelected = this.selectedIndex !== -1 ? this.options[this.selectedIndex] : null;
      },
      onButtonClick() {
        this.showCurriculas ||
          ((this.activeIndex = this.selectedIndex),
          (this.showCurriculas = !0),
          this.$nextTick(() => {
            this.$refs.listbox.focus(),
              this.$refs.listbox.children[this.activeIndex].scrollIntoView({
                block: "nearest",
              });
          }));
      },
      onOptionSelect() {
        null !== this.activeIndex && (this.selectedIndex = this.activeIndex), (this.showCurriculas = !1),(this.optionSelected = this.selectedIndex !== -1 ? this.options[this.selectedIndex] : null),
          this.$refs.button.focus();
      },
      onEscape() {
        (this.showCurriculas = !1), this.$refs.button.focus();
      },
       onArrowUp() {
        (this.activeIndex =
          this.activeIndex - 1 < 0
            ? this.optionCount - 1
            : this.activeIndex - 1),
          this.$refs.listbox.children[this.activeIndex].scrollIntoView({
            block: "nearest",//con center se posiciona al centro, con nearest se queda donde esta el scroll
          });
      },
      onArrowDown() {
        // console.log(this.activeIndex);
        // console.log(this.optionCount);
        // console.log('ref '+this.$refs.listbox.children[this.activeIndex].scrollIntoView({block: "nearest", }));
        (this.activeIndex = this.activeIndex + 1 > this.optionCount - 1 ? 0 : this.activeIndex + 1),
        this.$refs.listbox.children[this.activeIndex].scrollIntoView({block: "nearest", } );
      },
      onMouseEnter(e) {
        n.update(e);
      },
      onMouseMove(e, t) {
        n.wasMoved(e) && (this.activeIndex = t);
      },
      onMouseLeave(e) {
        n.wasMoved(e) && (this.activeIndex = null);
      },
    
        };
    
            //         console.log(config.data)
            //         return {
            //              showFormCreate: false,
            // modalDelete: false,
            // showFormEditAlp: false,
            // showSolicitud: true,
            // showForm: true,
            //             data: config.data,

            //             emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',

            //             focusedOptionIndex: null,

            //             name: config.name,

            //             showCurriculas: false,

            //             options: {},

            //             placeholder: config.placeholder ?? 'Seleccione una Curricula',

                    

            //             value: config.value,

            //             closeListbox: function () {
            //                 this.showCurriculas = false

            //                 this.focusedOptionIndex = null

                            
            //             },

            //             focusNextOption: function () {
            //                 if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options).length - 1

            //                 if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

            //                 this.focusedOptionIndex++

            //                 this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
            //                     block: "center",
            //                 })
            //             },

            //             focusPreviousOption: function () {
            //                 if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

            //                 if (this.focusedOptionIndex <= 0) return

            //                 this.focusedOptionIndex--

            //                 this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
            //                     block: "center",
            //                 })
            //             },

            //             init: function () {
            //                 this.options = this.data

            //                 if (!(this.value in this.options)) this.value = null

                        
            //             },

            //             selectOption: function () {
            //                 if (!this.showCurriculas) return this.toggleListboxVisibility()

            //                 this.value = this.options[this.focusedOptionIndex].id

            //                 this.closeListbox()
            //             },

            //             toggleListboxVisibility: function () {
            //                 if (this.showCurriculas) return this.closeListbox()

            //                 this.focusedOptionIndex =this.options.findIndex(option => option.id === this.value)

            //                 if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

            //                 this.showCurriculas = true

            //                 // this.$nextTick(() => {
            //                 //     this.$refs.search.focus()

            //                 //     this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
            //                 //         block: "center"
            //                 //     })
            //                 // })
            //             },
            //         }
            //     
        
        
}

 
 

       
      