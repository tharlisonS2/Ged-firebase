@extends("template.tinicio")
@section("titulo", "Documentos")
@section("conteudo")
<script>
  /*
   *   This content is licensed according to the W3C Software License at
   *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
   *
   *   File:   Treeitem.js
   *
   *   Desc:   Treeitem widget that implements ARIA Authoring Practices
   *           for a tree being used as a file viewer
   */

  'use strict';

  /*
   *   @constructor
   *
   *   @desc
   *       Treeitem object for representing the state and user interactions for a
   *       treeItem widget
   *
   *   @param node
   *       An element with the role=tree attribute
   */

  var Treeitem = function(node, treeObj, group) {
    // Check whether node is a DOM element
    if (typeof node !== 'object') {
      return;
    }

    node.tabIndex = -1;
    this.tree = treeObj;
    this.groupTreeitem = group;
    this.domNode = node;
    this.label = node.textContent.trim();

    if (node.getAttribute('aria-label')) {
      this.label = node.getAttribute('aria-label').trim();
    }

    this.isExpandable = false;
    this.isVisible = false;
    this.inGroup = false;

    if (group) {
      this.inGroup = true;
    }

    var elem = node.firstElementChild;

    while (elem) {
      if (elem.tagName.toLowerCase() == 'ul') {
        elem.setAttribute('role', 'group');
        this.isExpandable = true;
        break;
      }

      elem = elem.nextElementSibling;
    }

    this.keyCode = Object.freeze({
      RETURN: 13,
      SPACE: 32,
      PAGEUP: 33,
      PAGEDOWN: 34,
      END: 35,
      HOME: 36,
      LEFT: 37,
      UP: 38,
      RIGHT: 39,
      DOWN: 40,
    });
  };

  Treeitem.prototype.init = function() {
    this.domNode.tabIndex = -1;

    if (!this.domNode.getAttribute('role')) {
      this.domNode.setAttribute('role', 'treeitem');
    }

    this.domNode.addEventListener('keydown', this.handleKeydown.bind(this));
    this.domNode.addEventListener('click', this.handleClick.bind(this));
    this.domNode.addEventListener('focus', this.handleFocus.bind(this));
    this.domNode.addEventListener('blur', this.handleBlur.bind(this));

    if (!this.isExpandable) {
      this.domNode.addEventListener('mouseover', this.handleMouseOver.bind(this));
      this.domNode.addEventListener('mouseout', this.handleMouseOut.bind(this));
    }
  };

  Treeitem.prototype.isExpanded = function() {
    if (this.isExpandable) {
      return this.domNode.getAttribute('aria-expanded') === 'true';
    }

    return false;
  };

  /* EVENT HANDLERS */

  Treeitem.prototype.handleKeydown = function(event) {
    var tgt = event.currentTarget,
      flag = false,
      char = event.key,
      clickEvent;

    function isPrintableCharacter(str) {
      return str.length === 1 && str.match(/\S/);
    }

    function printableCharacter(item) {
      if (char == '*') {
        item.tree.expandAllSiblingItems(item);
        flag = true;
      } else {
        if (isPrintableCharacter(char)) {
          item.tree.setFocusByFirstCharacter(item, char);
          flag = true;
        }
      }
    }

    if (event.altKey || event.ctrlKey || event.metaKey) {
      return;
    }

    if (event.shift) {
      if (isPrintableCharacter(char)) {
        printableCharacter(this);
      }
    } else {
      switch (event.keyCode) {
        case this.keyCode.SPACE:
        case this.keyCode.RETURN:
          // Create simulated mouse event to mimic the behavior of ATs
          // and let the event handler handleClick do the housekeeping.
          clickEvent = new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true,
          });
          tgt.dispatchEvent(clickEvent);
          flag = true;
          break;

        case this.keyCode.UP:
          this.tree.setFocusToPreviousItem(this);
          flag = true;
          break;

        case this.keyCode.DOWN:
          this.tree.setFocusToNextItem(this);
          flag = true;
          break;

        case this.keyCode.RIGHT:
          if (this.isExpandable) {
            if (this.isExpanded()) {
              this.tree.setFocusToNextItem(this);
            } else {
              this.tree.expandTreeitem(this);
            }
          }
          flag = true;
          break;

        case this.keyCode.LEFT:
          if (this.isExpandable && this.isExpanded()) {
            this.tree.collapseTreeitem(this);
            flag = true;
          } else {
            if (this.inGroup) {
              this.tree.setFocusToParentItem(this);
              flag = true;
            }
          }
          break;

        case this.keyCode.HOME:
          this.tree.setFocusToFirstItem();
          flag = true;
          break;

        case this.keyCode.END:
          this.tree.setFocusToLastItem();
          flag = true;
          break;

        default:
          if (isPrintableCharacter(char)) {
            printableCharacter(this);
          }
          break;
      }
    }

    if (flag) {
      event.stopPropagation();
      event.preventDefault();
    }
  };

  Treeitem.prototype.handleClick = function(event) {
    if (this.isExpandable) {
      if (this.isExpanded()) {
        this.tree.collapseTreeitem(this);
      } else {
        this.tree.expandTreeitem(this);
      }
      event.stopPropagation();
    } else {
      this.tree.setFocusToItem(this);
    }
  };

  Treeitem.prototype.handleFocus = function() {
    var node = this.domNode;
    if (this.isExpandable) {
      node = node.firstElementChild;
    }
    node.classList.add('focus');
  };

  Treeitem.prototype.handleBlur = function() {
    var node = this.domNode;
    if (this.isExpandable) {
      node = node.firstElementChild;
    }
    node.classList.remove('focus');
  };

  Treeitem.prototype.handleMouseOver = function(event) {
    event.currentTarget.classList.add('hover');
  };

  Treeitem.prototype.handleMouseOut = function(event) {
    event.currentTarget.classList.remove('hover');
  };
  /*
   *   This content is licensed according to the W3C Software License at
   *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
   *
   *   File:   Treeitem.js
   *
   *   Desc:   Setup click events for Tree widget examples
   */

  'use strict';

  /**
   * ARIA Treeview example
   *
   * @function onload
   * @description  after page has loaded initialize all treeitems based on the role=treeitem
   */

  window.addEventListener('load', function() {
    var treeitems = document.querySelectorAll('[role="treeitem"]');

    for (var i = 0; i < treeitems.length; i++) {
      treeitems[i].addEventListener('click', function(event) {
        var treeitem = event.currentTarget;
        var label = treeitem.getAttribute('aria-label');
        if (!label) {
          var child = treeitem.firstElementChild;
          label = child ? child.innerText : treeitem.innerText;
        }

        document.getElementById('last_action').value = label.trim();

        event.stopPropagation();
        event.preventDefault();
      });
    }
  });
  /*
   *   This content is licensed according to the W3C Software License at
   *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
   *
   *   File:   Tree.js
   *
   *   Desc:   Tree widget that implements ARIA Authoring Practices
   *           for a tree being used as a file viewer
   */

  /* global Treeitem */

  'use strict';

  /**
   * ARIA Treeview example
   *
   * @function onload
   * @description  after page has loaded initialize all treeitems based on the role=treeitem
   */

  window.addEventListener('load', function() {
    var trees = document.querySelectorAll('[role="tree"]');

    for (var i = 0; i < trees.length; i++) {
      var t = new Tree(trees[i]);
      t.init();
    }
  });

  /*
   *   @constructor
   *
   *   @desc
   *       Tree item object for representing the state and user interactions for a
   *       tree widget
   *
   *   @param node
   *       An element with the role=tree attribute
   */

  var Tree = function(node) {
    // Check whether node is a DOM element
    if (typeof node !== 'object') {
      return;
    }

    this.domNode = node;

    this.treeitems = [];
    this.firstChars = [];

    this.firstTreeitem = null;
    this.lastTreeitem = null;
  };

  Tree.prototype.init = function() {
    function findTreeitems(node, tree, group) {
      var elem = node.firstElementChild;
      var ti = group;

      while (elem) {
        if (elem.tagName.toLowerCase() === 'li') {
          ti = new Treeitem(elem, tree, group);
          ti.init();
          tree.treeitems.push(ti);
          tree.firstChars.push(ti.label.substring(0, 1).toLowerCase());
        }

        if (elem.firstElementChild) {
          findTreeitems(elem, tree, ti);
        }

        elem = elem.nextElementSibling;
      }
    }

    // initialize pop up menus
    if (!this.domNode.getAttribute('role')) {
      this.domNode.setAttribute('role', 'tree');
    }

    findTreeitems(this.domNode, this, false);

    this.updateVisibleTreeitems();

    this.firstTreeitem.domNode.tabIndex = 0;
  };

  Tree.prototype.setFocusToItem = function(treeitem) {
    for (var i = 0; i < this.treeitems.length; i++) {
      var ti = this.treeitems[i];

      if (ti === treeitem) {
        ti.domNode.tabIndex = 0;
        ti.domNode.focus();
      } else {
        ti.domNode.tabIndex = -1;
      }
    }
  };

  Tree.prototype.setFocusToNextItem = function(currentItem) {
    var nextItem = false;

    for (var i = this.treeitems.length - 1; i >= 0; i--) {
      var ti = this.treeitems[i];
      if (ti === currentItem) {
        break;
      }
      if (ti.isVisible) {
        nextItem = ti;
      }
    }

    if (nextItem) {
      this.setFocusToItem(nextItem);
    }
  };

  Tree.prototype.setFocusToPreviousItem = function(currentItem) {
    var prevItem = false;

    for (var i = 0; i < this.treeitems.length; i++) {
      var ti = this.treeitems[i];
      if (ti === currentItem) {
        break;
      }
      if (ti.isVisible) {
        prevItem = ti;
      }
    }

    if (prevItem) {
      this.setFocusToItem(prevItem);
    }
  };

  Tree.prototype.setFocusToParentItem = function(currentItem) {
    if (currentItem.groupTreeitem) {
      this.setFocusToItem(currentItem.groupTreeitem);
    }
  };

  Tree.prototype.setFocusToFirstItem = function() {
    this.setFocusToItem(this.firstTreeitem);
  };

  Tree.prototype.setFocusToLastItem = function() {
    this.setFocusToItem(this.lastTreeitem);
  };

  Tree.prototype.expandTreeitem = function(currentItem) {
    if (currentItem.isExpandable) {
      currentItem.domNode.setAttribute('aria-expanded', true);
      this.updateVisibleTreeitems();
    }
  };

  Tree.prototype.expandAllSiblingItems = function(currentItem) {
    for (var i = 0; i < this.treeitems.length; i++) {
      var ti = this.treeitems[i];

      if (ti.groupTreeitem === currentItem.groupTreeitem && ti.isExpandable) {
        this.expandTreeitem(ti);
      }
    }
  };

  Tree.prototype.collapseTreeitem = function(currentItem) {
    var groupTreeitem = false;

    if (currentItem.isExpanded()) {
      groupTreeitem = currentItem;
    } else {
      groupTreeitem = currentItem.groupTreeitem;
    }

    if (groupTreeitem) {
      groupTreeitem.domNode.setAttribute('aria-expanded', false);
      this.updateVisibleTreeitems();
      this.setFocusToItem(groupTreeitem);
    }
  };

  Tree.prototype.updateVisibleTreeitems = function() {
    this.firstTreeitem = this.treeitems[0];

    for (var i = 0; i < this.treeitems.length; i++) {
      var ti = this.treeitems[i];

      var parent = ti.domNode.parentNode;

      ti.isVisible = true;

      while (parent && parent !== this.domNode) {
        if (parent.getAttribute('aria-expanded') == 'false') {
          ti.isVisible = false;
        }
        parent = parent.parentNode;
      }

      if (ti.isVisible) {
        this.lastTreeitem = ti;
      }
    }
  };

  Tree.prototype.setFocusByFirstCharacter = function(currentItem, char) {
    var start, index;

    char = char.toLowerCase();

    // Get start index for search based on position of currentItem
    start = this.treeitems.indexOf(currentItem) + 1;
    if (start === this.treeitems.length) {
      start = 0;
    }

    // Check remaining slots in the menu
    index = this.getIndexFirstChars(start, char);

    // If not found in remaining slots, check from beginning
    if (index === -1) {
      index = this.getIndexFirstChars(0, char);
    }

    // If match was found...
    if (index > -1) {
      this.setFocusToItem(this.treeitems[index]);
    }
  };

  Tree.prototype.getIndexFirstChars = function(startIndex, char) {
    for (var i = startIndex; i < this.firstChars.length; i++) {
      if (this.treeitems[i].isVisible) {
        if (char === this.firstChars[i]) {
          return i;
        }
      }
    }
    return -1;
  };
</script>
<ul class="nav menu bg-dark">
  <li class="nav-item" id="logo">
    <a class="navbar-brand m-4" id="logo" aria-current="page" href="#">Storage</a>
  </li>
  <li>
    <form class="w-100 m-2">
      <div class="input-group">
        <button class="btn btn-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown" aria-expanded="false">Pasta</button>
        <ul class="dropdown-menu ">
          <li><a class="dropdown-item" href="#">Action before</a></li>
          <li><a class="dropdown-item" href="#">Another action before</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
        <input type="text" class="form-control" placeholder="Buscar" aria-label="Text input with 2 dropdown buttons" required>
        <button class="btn btn-secondary " type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>

      </div>
    </form>
  </li>

  <li class="nav-item hover-nome">
    <div class="my-container ">
      <div class="dropdown me-3 ">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" style="color:white;" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{Session::get('photoUrl')}}" alt="" width="32" height="32" class="rounded-circle me-2">
          <span class="text-light ">Carlos alberto de nobrega</span>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>
  </li>
</ul>
<div class="d-flex alt ">
  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav-select" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="#"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>
  <div class=" navl bg-light upload shadow-lg">
    <div class=" ">
      @foreach($buckets as $object1)
      @if($object1->info()["size"]==0&&isset($object1->info()['metadata']['Raizdepartamento']))
      <ul role="tree" aria-labelledby="tree_label">
        <li role="treeitem" aria-expanded="false"><span class="nav-link w-50">teste</span>
          <ul role="group" class="">
            @foreach($buckets2 as $objectfilho)
            @if(isset($objectfilho->info()['metadata']['pai']))
            @if($object1->name()==$objectfilho->info()['metadata']['pai'])
            <li role="treeitem" aria-expanded="false">
            <li role="treeitem" aria-expanded="false"><span class="nav-link w-50"><a href="#">teste</a></span>
              @elseif(isset($filho)&&$filho==$objectfilho->info()['metadata']['pai'])
              <ul role="group">
                <li role="treeitem" aria-expanded="false">
              </ul>
              @else
              <ul role="group">
                <li role="treeitem" aria-expanded="false">
              </ul>
              @endif
              @endif
              @php
              if(isset($objectfilho->info()['metadata']['pai']))
              if($objectfilho->info()['metadata']['pai']==$object1->name())
              $filho=$objectfilho->name()
              @endphp
              @endforeach
            </li>
          </ul>
          @endif
      @endforeach
        </li>
      </ul>
    </div>
    <div class="btn-group m-5" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-dark caminho-nav  shadow-lg" data-toggle="modal" data-target="#criardepartamento">+</button>
      <button type="button" class="btn btn-dark caminho-nav shadow-lg " data-toggle="modal" data-target="#exampleModal">Upload</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-light" id="exampleModalLabel">Upload documento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form action="{{route('documento')}}" enctype="multipart/form-data" method="post">
              @csrf
              <div class="form-group col-15">
                <label for="nome">Nome arquivo: </label>
                <input type="text" id="nome" name="nomearquivo" class="form-control" placeholder="Insira nome" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
              </div>
              <div class="form-group col-15">
                <label for="nome">Caminho: </label>
                <select name="departamento" class="form-control" required>
                  <option value="" selected="selected"></option>
                  @foreach($caminhopasta as $depar)

                  <option value="{{$depar}}">{{$depar}}</option>
                  @endforeach
                </select>
                <div class="form-group row-10 mt-3">
                  <input class="form-check-input align-center" type="checkbox" value="true" name="manterbloqueado" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    Manter Bloqueado
                  </label>
                </div>
              </div></br>
              <input type="file" name="arquivo" class="form-control "></br>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="criardepartamento" tabindex="-1" role="dialog" aria-labelledby="criardepartamentoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-light" id="criardepartamentoLabel">Criar Departamento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form action="/documento/criardepartamento" enctype="multipart/form-data" method="post">
              @csrf
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Raiz/</span>
                <input type="text" class="form-control" placeholder="Nome da pasta" aria-label="nomepasta" name="nomepasta" aria-describedby="basic-addon1" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
  <div class="w-100">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="m-0 breadcrumb">
            <li class="breadcrumb-item"><a href="/documento" class="text-decoration-none">{{$caminho}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">1723131316391246714</li>
          </ol>
        </nav>
      </div>
    </div>
    <table class="table responsive  table-dark table-borderless  table-hover  wid m-2 rounded shadow-lg" id="table">
      <colgroup>
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="0">
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>TIPO</th>
          <th>TAMANHO</th>
          <th>AÇOES</th>

        </tr>
      </thead>
      <tbody>
        @if(isset($files))
        @foreach($files as $object)
        @if($object->info()['contentType']=='application/x-www-form-urlencoded;charset=UTF-8'||$object->info()["size"]<=0) @else <tr>

          <td>#{{$object->info()['generation']}}</td>
          <td><i class="fa-solid fa-file-image text-info me-1"></i><i class="fa-solid fa-file-pdf text-danger me-1"></i>{{substr($object->name(), strpos($object->name(), '/'))}}</td>
          <td>{{$object->info()['contentType']}}</td>
          <td>{{$object->info()['size']}} Bytes</td>
          <td>
            <div class="d-flex">
              <div class="btn-group p-0 m-0">
                <form action="" method="POST" name="delete">
                  @csrf
                  <input type="hidden" name="_method" value="DELETE" />
                  <button type='submit' id="deletar" class="d-none acao-icon" onclick="return confirm('Deseja deletar o arquivo?')"></button>
                  <label class="acao-icon h-100 " for="deletar"><i for="deletar" class="far fa-trash-alt text-danger" style="font-size:20px;"></i></label>
                </form>
              </div>
              <div class="btn-group p-0 mx-3 ">

                <form action="" method="POST" name="visualizar">
                  @csrf
                  <button type='submit' class="d-none" id="visualizar"></button>
                  <label class="acao-icon h-100 " for="visualizar"><i for="visualizar" class="text-center fas fa-eye text-info" style="font-size:20px;"></i></label>
                </form>
              </div>
              <div class="btn-group p-0 m-0">
                <form action="" method="POST" name="download">
                  @csrf
                  <button type='submit' class="d-none acao-icon" id="download" onclick="return confirm('Deseja deletar o arquivo?')"></button>
                  <label class="acao-icon h-100 " for="download"><i for="download" class="fas fa-cloud-download-alt  text-primary" style="font-size:20px;"></i></label>


                </form>
              </div>
            </div>
          </td>
          @endif
          @endforeach
          @endif
      </tbody>
  </div>
</div>


</div>
<script>
  function ApenasLetras(e, t) {
    try {
      if (window.event) {
        var charCode = window.event.keyCode;
      } else if (e) {
        var charCode = e.which;
      } else {
        return true;
      }
      if (
        (charCode > 64 && charCode < 91) ||
        (charCode > 96 && charCode < 123) ||
        (charCode > 191 && charCode <= 255) // letras com acentos
      ) {
        return true;
      } else {
        return false;
      }
    } catch (err) {
      alert(err.Description);
    }
  }
</script>
<script>
  $('a.btn').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $(".modal-body").html('<iframe width="500px" height="500px" frameborder="0" scrolling="yes" allowtransparency="true" src="' + url + '"></iframe>');
  });
</script>
@endsection