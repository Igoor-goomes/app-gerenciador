$(function(){
  // UTIL shared for forms
  function flattenAtributos($form){
    const chaves = $form.find("input[name='atributo[chave][]']").map((i,el)=>el.value).get();
    const valores = $form.find("input[name='atributo[valor][]']").map((i,el)=>el.value).get();
    const obj = {};
    chaves.forEach((k, i)=>{ if(k) obj[k]=valores[i] ?? ''; });
    $form.find("input[name='atributo[chave][]'], input[name='atributo[valor][]']").remove();
    $('<input>').attr({type:'hidden', name:'atributo', value: JSON.stringify(obj)}).appendTo($form[0]);
  }
  function bindAddCategoria(buttonSelector, wrapperSelector){
    $(document).on('click', buttonSelector, function(){
      const wrap = document.querySelector(wrapperSelector);
      if (!wrap) return;
      const inp = document.createElement('input');
      inp.type='text'; inp.name='categoria[]'; inp.placeholder='Outra categoria'; inp.className='form-control mb-2';
      wrap.appendChild(inp);
    });
  }
  function bindAddAtributo(buttonSelector, wrapperSelector){
    $(document).on('click', buttonSelector, function(){
      const wrap = document.querySelector(wrapperSelector);
      if (!wrap) return;
      const row = document.createElement('div');
      row.className='row g-2 align-items-center mb-2';
      row.innerHTML = '<div class="col"><input type="text" class="form-control" name="atributo[chave][]" placeholder="Chave"></div>'+
                      '<div class="col"><input type="text" class="form-control" name="atributo[valor][]" placeholder="Valor"></div>';
      wrap.appendChild(row);
    });
  }

  // Bind dynamic add buttons for modal/create/edit
  bindAddCategoria('button[onclick="addCategoriaField()"]', '#categorias-wrapper');
  bindAddAtributo('button[onclick="addAtributoField()"]', '#atributos-wrapper');
  bindAddCategoria('button[onclick="addCategoriaFieldCreate()"]', '#categorias-wrapper-create');
  bindAddAtributo('button[onclick="addAtributoFieldCreate()"]', '#atributos-wrapper-create');
  bindAddCategoria('button[onclick="addCategoriaFieldEdit()"]', '#categorias-wrapper-edit');
  bindAddAtributo('button[onclick="addAtributoFieldEdit()"]', '#atributos-wrapper-edit');
  function onlyDigits(str){ return (str||'').replace(/\D+/g,''); }
  function formatMoneyBRFromDigits(digits){
    // digits: string only numbers, interpret as cents
    if(!digits) return 'R$ 0,00';
    const cents = parseInt(digits,10);
    const value = (cents/100).toFixed(2);
    return 'R$ ' + value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }
  // BRL mask helpers
  function applyMoneyMask($input){
    $input.attr('inputmode','numeric');
    $input.on('input', function(){
      const digits = onlyDigits($(this).val());
      if (!digits) { $(this).val(''); return; }
      $(this).val(formatMoneyBRFromDigits(digits));
    });
    $input.on('focus', function(){ const el=this; setTimeout(()=>{ el.selectionStart=el.selectionEnd=el.value.length; },0);});
  }
  function parseMoneyToNumber(str){
    if(!str) return '';
    // Accept inputs like "R$ 1.234,56" or "1.234,56" or "1234,56"
    const cleaned = (str+'').replace(/[^\d,.-]/g,'').replace(/\./g,'').replace(',', '.');
    const n = parseFloat(cleaned);
    return isNaN(n)? '': n;
  }
  const table = $('#tabela-dashboard').DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    searching: false,
    info: true,
    language: {
      emptyTable: 'Nenhum registro encontrado',
      info: 'Mostrando _START_ até _END_ de _TOTAL_ registros',
      infoEmpty: 'Mostrando 0 até 0 de 0 registros',
      infoFiltered: '(Filtrado de _MAX_ registros)',
      infoThousands: '.',
      lengthMenu: 'Mostrar _MENU_ registros',
      loadingRecords: 'Carregando...',
      processing: 'Processando...',
      search: 'Buscar:',
      zeroRecords: 'Nenhum registro encontrado',
      paginate: { first: 'Primeiro', previous: 'Anterior', next: 'Próximo', last: 'Último' },
      aria: { sortAscending: ': Ordenar colunas de forma ascendente', sortDescending: ': Ordenar colunas de forma descendente' }
    },
    ajax: {
      url: window.routes && window.routes.produtosDatatable ? window.routes.produtosDatatable : '/gerenciador/produtos/datatable',
      data: function (d) {
        d.q = $('input[name="q"]').val();
        d.preco_min = parseMoneyToNumber($('input[name="preco_min"]').val());
        d.preco_max = parseMoneyToNumber($('input[name="preco_max"]').val());
        d.estoque_min = $('input[name="estoque_min"]').val();
        d.estoque_max = $('input[name="estoque_max"]').val();
      }
    },
    columns: [
      { data: 'nome', name: 'nome' },
      { data: 'descricao', name: 'descricao', render: function(data,type,row){
          if (type === 'display' || type === 'filter') {
            const text = data || '-';
            return '<span class="dt-desc-ellipsis" title="'+ $('<div>').text(text).html() +'">'+ $('<div>').text(text).html() +'</span>';
          }
          return data;
        }
      },
      { data: 'preco', name: 'preco', className: 'text-end' },
      { data: 'total', name: 'total', className: 'text-end' },
      { data: 'quantidade_estoque', name: 'quantidade_estoque', className: 'text-end' },
      { data: 'acoes', name: 'acoes', orderable: false, searchable: false, className: 'text-end' },
    ],
    order: []
  });

  // Handle delete with SweetAlert and AJAX fallback
  $(document).on('submit', '.form-delete-produto', async function(e){
    e.preventDefault();
    const form = this;
    const ok = await (window.AppUI && AppUI.confirm ? AppUI.confirm('Excluir produto?', 'Esta ação não poderá ser desfeita.') : Promise.resolve(confirm('Excluir?')));
    if (!ok) return;
    try {
      await $.ajax({ url: $(form).attr('action'), method: 'POST', data: $(form).serialize() });
      if (window.AppUI && AppUI.toast) AppUI.toast('Produto removido com sucesso.', 'success');
      table.ajax.reload(null, false);
    } catch (xhr) {
      if (window.AppUI && AppUI.toast) AppUI.toast('Falha ao remover.', 'error');
    }
  });

  // Only handle the filter form (GET). Do not block other forms (e.g., logout)
  $('form[method="GET"]').on('submit', function(e){
    e.preventDefault();
    table.ajax.reload();
  });

  // Apply BRL masks on filters and modal/create/edit inputs
  applyMoneyMask($("input[name='preco_min']"));
  applyMoneyMask($("input[name='preco_max']"));
  // apply mask when modal opens (ensures element exists)
  $('#modalNovoProduto').on('shown.bs.modal', function(){
    const $p = $(this).find("input[name='preco']");
    if ($p.length) applyMoneyMask($p);
    $p.trigger('focus');
  });

  // also bind click on any opener of the modal to pre-apply mask shortly after click
  $(document).on('click', "[data-bs-target='#modalNovoProduto']", function(){
    setTimeout(function(){
      const $modal = $('#modalNovoProduto');
      const $p = $modal.find("input[name='preco']");
      if ($p.length) applyMoneyMask($p);
    }, 50);
  });

  $('#formNovoProduto').on('submit', async function(e){
    e.preventDefault();
    const $form = $(this);
    const $errors = $('#novoProdutoErrors');
    $errors.addClass('d-none').empty();
    try {
      // Use the numeric value directly
      const precoNumber = parseFloat($form.find("input[name='preco']").val());
      const payload = $form.serializeArray().reduce((acc, it)=>{ 
        if (acc[it.name] !== undefined) {
          if (!Array.isArray(acc[it.name])) acc[it.name] = [acc[it.name]];
          acc[it.name].push(it.value);
        } else {
          acc[it.name]=it.value; 
        }
        return acc; 
      }, {});
      payload.preco = parseMoneyToNumber($form.find("input[name='preco']").val());
      payload.preco_unitario = payload.preco;

      // Converte campos de atributo enviados como atributo[chave][] e atributo[valor][] em objeto associativo
      if (payload['atributo[chave][]'] || payload['atributo[valor][]']) {
        const keys = payload['atributo[chave][]'] || [];
        const vals = payload['atributo[valor][]'] || [];
        const obj = {};
        (Array.isArray(keys)? keys : [keys]).forEach((k, i)=>{
          if (k) obj[k] = Array.isArray(vals) ? (vals[i] ?? '') : vals;
        });
        delete payload['atributo[chave][]'];
        delete payload['atributo[valor][]'];
        payload['atributo'] = obj;
      }
      await $.ajax({ url: $form.attr('action'), method: 'POST', data: payload });
      const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNovoProduto'));
      modal.hide();
      $form[0].reset();
      if (window.AppUI && AppUI.toast) AppUI.toast('Produto criado com sucesso.', 'success');
      table.ajax.reload(null, false);
    } catch (xhr) {
      const data = xhr.responseJSON || {};
      let msgs = [];
      if (data.errors) { Object.values(data.errors).forEach(a=>msgs.push(...a)); }
      else if (data.message) { msgs.push(data.message); }
      else { msgs.push('Falha ao salvar.'); }
      $errors.html(msgs.map(m=>`<div>${m}</div>`).join('')).removeClass('d-none');
      if (window.AppUI && AppUI.toast) AppUI.toast('Falha ao salvar.', 'error');
    }
  });
});
