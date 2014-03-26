$('.datepicker').pickadate({
  format: 'dd.mm.yyyy',
  editable: true,
});

$('.timepicker').pickatime({
  format: 'HH:i',
  interval: 15,
  editable: true,
  min: [7,30],
  max: [19,0]
})