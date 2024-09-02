let senegalContenaire = $('#montantSenegal');
const barChartEl = document.querySelector('#barChart');
const barChartBenin = document.querySelector('#barChartBenin');
const barCoteIvoire = document.querySelector('#barCoteIvoire');
const barTogo = document.querySelector('#barTogo');
const barGambie = document.querySelector('#barGambie');
const banqueSenegal = document.getElementById("banquesenegal");

let donutChartEl = document.querySelector('#donutChart');
let  barChart, donutChart, chartAgences, drawChartCote, drawChartGambie, drawChartTogo, drawChartBenin;
let cardColor, headingColor, labelColor, borderColor, legendColor;

if (isDarkStyle) {
  cardColor = config.colors_dark.cardColor;
  headingColor = config.colors_dark.headingColor;
  labelColor = config.colors_dark.textMuted;
  legendColor = config.colors_dark.bodyColor;
  borderColor = config.colors_dark.borderColor;
} else {
  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  labelColor = config.colors.textMuted;
  legendColor = config.colors.bodyColor;
  borderColor = config.colors.borderColor;
}

// Color constant
const chartColors = {
  column: {
    series1: '#0070B3',
    series2: '#6cc735',
    series3: '#c9123d',
    bg: '#f8d3ff'
  },
  donut: {
    series1: '#fee802',
    series2: '#3fd0bd',
    series3: '#826bf8',
    series4: '#2b9bf4'
  },
  area: {
    series1: '#29dac7',
    series2: '#60f2ca',
    series3: '#a5f8cd'
  }
};
let nombreSn, nombreTg, nombreGb, nombreCi, nombreBn;

  $.ajax({
    type: 'GET',
    url: `${baseUrl}montant/pays`,
    success: function(res) {

      nombreSn = res.montantSenegal;
      nombreGb = res.montantGambie;
      nombreTg = res.montantTogo;
      nombreBn = res.montantBenin;
      nombreCi = res.montantCote;
    }
  }).then(() => {
    new CountUp('montantSenegal', nombreSn, { formattingFn(n) {return fm.from(n);} }).start();
    new CountUp('montantGambie', nombreGb, { formattingFn(n) {return fm.from(n);} }).start();
    new CountUp('montantTogo', nombreTg, { formattingFn(n) {return fm.from(n);} }).start();
    new CountUp('montantBenin', nombreBn, { formattingFn(n) {return fm.from(n);} }).start();
    new CountUp('montantCote', nombreCi, { formattingFn(n) {return fm.from(n);} }).start();
  });

  Echo.channel('transaction-deleted')
    .listen('.transaction.deleted',(event) =>{

      $.ajax({
        type: 'GET',
        url: `${baseUrl}montant/pays`,
        success: function(res) {

          nombreSn = res.montantSenegal;
          nombreGb = res.montantGambie;
          nombreTg = res.montantTogo;
          nombreBn = res.montantBenin;
          nombreCi = res.montantCote;
        }
      }).then(() => {
        new CountUp('montantSenegal', nombreSn, { formattingFn(n) {return fm.from(n);} }).start();
        new CountUp('montantGambie', nombreGb, { formattingFn(n) {return fm.from(n);} }).start();
        new CountUp('montantTogo', nombreTg, { formattingFn(n) {return fm.from(n);} }).start();
        new CountUp('montantBenin', nombreBn, { formattingFn(n) {return fm.from(n);} }).start();
        new CountUp('montantCote', nombreCi, { formattingFn(n) {return fm.from(n);} }).start();
      });

      $.ajax({
        type: 'GET',
        url: `${baseUrl}montant/pays`,
        success: function(res) {
          if (event.transaction.pays_id === 1) {
            let senegal = new CountUp('montantSenegal', res.montantSenegal, {
              startVal: nombreSn,
              formattingFn(n) {
                return fm.from(n);
              },
              suffix: ' CFA'
            });
            senegal.start();
          } else if (event.transaction.pays_id === 2) {
            let coteIvoire = new CountUp('montantCote', res.montantCote, {
              startVal: nombreSn,
              formattingFn(n) {
                let num = fm.from(n);
                return `${num} CFA`;
              },
              suffix: ' CFA'
            });
            coteIvoire.start();
          } else if (event.transaction.pays_id === 3) {
            let gambie = new CountUp('montantGambie', res.montantGambie, {
              startVal: nombreSn,
              formattingFn(n) {
                return fm.from(n);
              },
              suffix: ' CFA'
            });
            gambie.start();
          } else if (event.transaction.pays_id === 4) {
            let togo = new CountUp('montantTogo', res.montantTogo, {
              startVal: nombreSn,
              formattingFn(n) {
                return fm.from(n);
              },
              suffix: ' CFA'
            });
            togo.start();
          } else if (event.transaction.pays_id === 5) {
            let benin = new CountUp('montantBenin', res.montantBenin, {
              startVal: nombreSn,
              formattingFn(n) {
                return fm.from(n);
              },
              suffix: ' CFA'
            });
            benin.start();
          }


          nombreSn = res.montantSenegal;
          nombreTg = res.montantTogo;
          nombreGb = res.montantGambie;
          nombreBn = res.montantBenin;
          nombreCi = res.montantCote;
        }
      });

      /*
      Mise a jour des données analytiques du senegal
      montant Encours, payées, et impayées quand une transaction est crée
      **/


      statistiqueMoiSenegalBar(1);
      statistiqueMoiSenegalBar(2);
      statistiqueMoiSenegalBar(3);
      statistiqueMoiSenegalBar(4);
      statistiqueMoiSenegalBar(5);


      /*
      Mise à jour du donut Chart lors de la création d'une transaction
      */
      statistiqueMoisSenegal();

      //Mise à jour du graphiques des agences lors de la création d'une transaction
      updateAgenceChart();
    });
Echo.channel('transaction-created')
  .listen('.transaction.created', (event) => {
    $.ajax({
      type: 'GET',
      url: `${baseUrl}montant/pays`,
      success: function(res) {
        if (event.transaction.pays_id === 1) {
          let senegal = new CountUp('montantSenegal', res.montantSenegal, {
            startVal: nombreSn,
            formattingFn(n) {
              return fm.from(n);
            },
            suffix: ' CFA'
          });
          senegal.start();
        } else if (event.transaction.pays_id === 2) {
          let coteIvoire = new CountUp('montantCote', res.montantCote, {
            startVal: nombreSn,
            formattingFn(n) {
              let num = fm.from(n);
              return `${num} CFA`;
            },
            suffix: ' CFA'
          });
          coteIvoire.start();
        } else if (event.transaction.pays_id === 3) {
          let gambie = new CountUp('montantGambie', res.montantGambie, {
            startVal: nombreSn,
            formattingFn(n) {
              return fm.from(n);
            },
            suffix: ' CFA'
          });
          gambie.start();
        } else if (event.transaction.pays_id === 4) {
          let togo = new CountUp('montantTogo', res.montantTogo, {
            startVal: nombreSn,
            formattingFn(n) {
              return fm.from(n);
            },
            suffix: ' CFA'
          });
          togo.start();
        } else if (event.transaction.pays_id === 5) {
          let benin = new CountUp('montantBenin', res.montantBenin, {
            startVal: nombreSn,
            formattingFn(n) {
              return fm.from(n);
            },
            suffix: ' CFA'
          });
          benin.start();
        }


        nombreSn = res.montantSenegal;
        nombreTg = res.montantTogo;
        nombreGb = res.montantGambie;
        nombreBn = res.montantBenin;
        nombreCi = res.montantCote;
      }
    });

    /*
    Mise a jour des données analytiques du senegal
    montant Encours, payées, et impayées quand une transaction est crée
    **/


    statistiqueMoiSenegalBar(1);
    statistiqueMoiSenegalBar(2);
    statistiqueMoiSenegalBar(3);
    statistiqueMoiSenegalBar(4);
    statistiqueMoiSenegalBar(5);
    montantBanque();


    /*
    Mise à jour du donut Chart lors de la création d'une transaction
    */
    statistiqueMoisSenegal();

    //Mise à jour du graphiques des agences lors de la création d'une transaction
   updateAgenceChart();
  });



Echo.channel('transaction-updated')
  .listen('.transaction.updated',(event)=>{


    statistiqueMoisSenegal();
    /*
   Mise a jour des données analytiques du senegal
   montant Encours, payées, et impayées quand une transaction est mise à jour
   **/
    statistiqueMoiSenegalBar(1);
    statistiqueMoiSenegalBar(2);
    statistiqueMoiSenegalBar(3);
    statistiqueMoiSenegalBar(4);
    statistiqueMoiSenegalBar(5);
    montantBanque();



//Mise à jour du graphiques des agences lors de la mise à jour d'une transaction
    updateAgenceChart();

});


let senegalMois, senegalMontant, senegalPayees,senegalImpayees;

/*
 Création des données analytiques du senegal
   montant Encours, payées, et impayées

   */

let graphiquePays = function(pays) {
  $.ajax({
    type: 'GET',
    url: `${baseUrl}statistiques/pays/${pays}`,
    success: function(res) {

      return res;
    }

  })
    .then((response)=>{
    let  barChartConfig =
        {
          chart: {
            height: 400,
            type: 'bar',
            stacked: false,
            parentHeightOffset: 0,
            toolbar: {
              show: true,
              zoom: true,
              zoomin: true,
              zoomout: true,
            },

          },
          plotOptions: {
            bar: {
              columnWidth: '35%',
              dataLabels: {
                position: 'top'
              }

            }
          },
          dataLabels: {
            enabled: false
          },
          legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'start',
            labels: {
              colors: legendColor,
              useSeriesColors: true
            }
          },
          colors: [chartColors.column.series1, chartColors.column.series2, chartColors.column.series3],
          stroke: {
            show: true,
            colors: ['transparent']
          },
          grid: {
            borderColor: borderColor,
            xaxis: {
              lines: {
                show: true
              }
            }
          },
          series: [
            {
              name: 'Encours',
              data: response.senegalMontant
            },
            {
              name: 'Payées',
              data: response.senegalPayee
            },
            {
              name: 'Impayées',
              data: response.senegalImpayee
            }
          ],
          xaxis: {
            categories: response.senegalMois,
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
            labels: {
              style: {
                colors: labelColor,
                fontSize: '13px'
              }
            }
          },
          yaxis: {
            labels: {
              style: {
                colors: labelColor,
                fontSize: '13px'
              },
              formatter: function (value) {
                return fm.from(value)+' CFA';
              }
            }
          },
          fill: {
            opacity: 1
          }
        };
      if (typeof barChartEl !== undefined && barChartEl !== null &&  pays === 1) {

        barChart = new ApexCharts(barChartEl, barChartConfig);
        barChart.render();
      }
      if (typeof barChartBenin !== undefined && barChartBenin !== null && pays === 5) {

         drawChartBenin = new ApexCharts(barChartBenin, barChartConfig);
        drawChartBenin.render();
      }
      if (typeof barCoteIvoire !== undefined && barCoteIvoire !== null && pays === 2) {

         drawChartCote = new ApexCharts(barCoteIvoire, barChartConfig);
        drawChartCote.render();
      }
      if (typeof barTogo !== undefined && barTogo !== null && pays === 4) {

         drawChartTogo = new ApexCharts(barTogo, barChartConfig);
        drawChartTogo.render();
      }
      if (typeof barGambie !== undefined && barGambie !== null && pays === 3) {

         drawChartGambie = new ApexCharts(barGambie, barChartConfig);
        drawChartGambie.render();
      }



    });
  }
 graphiquePays(1);
graphiquePays(5);
graphiquePays(2);
graphiquePays(4);
graphiquePays(3);
montantBanque();





$.ajax({
  type:'GET',
  url:`${baseUrl}statistiques/mois/1`,
  success: function(res) {
    return res ;
  }
})
  .then((res)=>{

   donutChartEl = document.querySelector('#donutChart');
   let donutChartConfig = {
      chart: {
        height: 390,
        type: 'donut'
      },
      labels: ['Encours', 'Impayées', 'Terminées'],
      series: [res.encours, res.impayee, res.terminee],
      colors: [
        chartColors.donut.series1,
        chartColors.donut.series4,
        chartColors.donut.series3,
      ],
      stroke: {
        show: false,
        curve: 'straight'
      },
      dataLabels: {
        enabled: true,
        formatter: function (val, opt) {

          return val.toFixed(2) + '%';
        }
      },

      legend: {
        show: true,
        position: 'bottom',
        markers: { offsetX: -3 },
        itemMargin: {
          vertical: 3,
          horizontal: 10
        },
        labels: {
          colors: legendColor,
          useSeriesColors: false
        }
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                fontSize: '2rem',
                fontFamily: 'Public Sans',

              },
              value: {
                fontSize: '1.2rem',
                color: legendColor,
                fontFamily: 'Public Sans',
                formatter: function (val) {
                  return  fm.from(parseInt(val, 10)) + ' CFA';
                }
              },
              total: {
                show: true,
                fontSize: '1.5rem',
                color: headingColor,
                label: 'TOTAL ',
                formatter: function (w) {
                  let total =w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                  }, 0)
                  return fm.from(total)+' CFA';
                }
              }
            }
          }
        }
      },
      responsive: [
        {
          breakpoint: 992,
          options: {
            chart: {
              height: 380
            },
            legend: {
              position: 'bottom',
              labels: {
                colors: legendColor,
                useSeriesColors: false
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              height: 320
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      fontSize: '1.5rem'
                    },
                    value: {
                      fontSize: '1rem'
                    },
                    total: {
                      fontSize: '1.5rem'
                    }
                  }
                }
              }
            },
            legend: {
              position: 'bottom',
              labels: {
                colors: legendColor,
                useSeriesColors: false
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            chart: {
              height: 280
            },
            legend: {
              show: false
            }
          }
        },
        {
          breakpoint: 360,
          options: {
            chart: {
              height: 250
            },
            legend: {
              show: false
            }
          }
        }
      ]
    };
  if (typeof donutChartEl !== undefined && donutChartEl !== null) {
     donutChart = new ApexCharts(donutChartEl, donutChartConfig);
    donutChart.render();
  }
});

$.ajax({
  type:'GET',
  url:`${baseUrl}statistiques/agence/senegal`,
  success: function(res) {

    return res;
  }
}).then((res)=>{

  var options =
    {
      chart: {
        height: 500,
        type: 'bar',
        stacked: false,
        parentHeightOffset: 0,
        toolbar: {
          show: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
        },

      },
      plotOptions: {
        bar: {
          columnWidth: '35%',
          dataLabels: {
            position: 'top'
          }

        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'start',
        labels: {
          colors: legendColor,
          useSeriesColors: true
        }
      },
      colors: [config.colors.primary, config.colors.success, config.colors.warning],
      stroke: {
        show: true,
        colors: ['transparent']
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [
        {
          name: 'Encours',
          data: res.montantE
        },
        {
          name: 'Payées',
          data: res.montantT
        },
        {
          name: 'Impayées',
          data: res.montantI
        }
      ],
      xaxis: {
        categories: res.agences,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          },
          formatter: function (value) {
            return fm.from(value)+' CFA';
          }
        }
      },
      fill: {
        opacity: 1
      }
    };

  chartAgences = new ApexCharts(document.querySelector("#agenceChart"), options);

  chartAgences.render();
});

//données statisques des agences par mois
$.ajax({
  type: 'GET',
  url : `${baseUrl}statistiques/agence/senegal`,
  success: function(res) {


  }
})

function updateAgenceChart(){

  $.ajax({
    type:'GET',
    url:`${baseUrl}statistiques/agence/senegal`,
    success: function(res) {

      return res;
    }
  }).then((res)=>{

    chartAgences.updateOptions({
      chart: {
        height: 500,
        type: 'bar',
        stacked: false,
        parentHeightOffset: 0,
        toolbar: {
          show: true,
          zoom: true,
          zoomin: true,
          zoomout: true,
        },

      },
      plotOptions: {
        bar: {
          columnWidth: '35%',
          dataLabels: {
            position: 'top'
          }

        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'start',
        labels: {
          colors: legendColor,
          useSeriesColors: true
        }
      },
      colors: [config.colors.primary, config.colors.success, config.colors.warning],
      stroke: {
        show: true,
        colors: ['transparent']
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [
        {
          name: 'Encours',
          data: res.montantE
        },
        {
          name: 'Payées',
          data: res.montantT
        },
        {
          name: 'Impayées',
          data: res.montantI
        }
      ],
      xaxis: {
        categories: res.agences,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          },
          formatter: function (value) {
            return fm.from(value)+' CFA';
          }
        }
      },
      fill: {
        opacity: 1
      }
    }, false, true);
  });
}
function statistiqueMoisSenegal(){
  $.ajax({
    type:'GET',
    url:`${baseUrl}statistiques/mois/1`,
    success: function(res) {
      donutChart.updateOptions(
        {
        chart: {
          height: 390,
          type: 'donut'
        },
        labels: ['Encours', 'Impayées', 'Terminées'],
        series: [res.encours, res.impayee, res.terminee],
        colors: [
          chartColors.donut.series1,
          chartColors.donut.series4,
          chartColors.donut.series3,
        ],
        stroke: {
          show: false,
          curve: 'straight'
        },
        dataLabels: {
          enabled: true,
          formatter: function (val, opt) {

            return val.toFixed(2) + '%';
          }
        },

        legend: {
          show: true,
          position: 'bottom',
          markers: { offsetX: -3 },
          itemMargin: {
            vertical: 3,
            horizontal: 10
          },
          labels: {
            colors: legendColor,
            useSeriesColors: false
          }
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                name: {
                  fontSize: '2rem',
                  fontFamily: 'Public Sans',

                },
                value: {
                  fontSize: '1.2rem',
                  color: legendColor,
                  fontFamily: 'Public Sans',
                  formatter: function (val) {
                    return  fm.from(parseInt(val, 10)) + ' CFA';
                  }
                },
                total: {
                  show: true,
                  fontSize: '1.5rem',
                  color: headingColor,
                  label: 'TOTAL ',
                  formatter: function (w) {
                    let total =w.globals.seriesTotals.reduce((a, b) => {
                      return a + b
                    }, 0)
                    return fm.from(total)+' CFA';
                  }
                }
              }
            }
          }
        },
        responsive: [
          {
            breakpoint: 992,
            options: {
              chart: {
                height: 380
              },
              legend: {
                position: 'bottom',
                labels: {
                  colors: legendColor,
                  useSeriesColors: false
                }
              }
            }
          },
          {
            breakpoint: 576,
            options: {
              chart: {
                height: 320
              },
              plotOptions: {
                pie: {
                  donut: {
                    labels: {
                      show: true,
                      name: {
                        fontSize: '1.5rem'
                      },
                      value: {
                        fontSize: '1rem'
                      },
                      total: {
                        fontSize: '1.5rem'
                      }
                    }
                  }
                }
              },
              legend: {
                position: 'bottom',
                labels: {
                  colors: legendColor,
                  useSeriesColors: false
                }
              }
            }
          },
          {
            breakpoint: 420,
            options: {
              chart: {
                height: 280
              },
              legend: {
                show: false
              }
            }
          },
          {
            breakpoint: 360,
            options: {
              chart: {
                height: 250
              },
              legend: {
                show: false
              }
            }
          }
        ]
      }, false, true);
    }
  });
}

function statistiqueMoiSenegalBar(paysId){
  $.ajax({
    type: 'GET',
    url: `${baseUrl}statistiques/pays/${paysId}`,
    success: function(res) {
      senegalMois = res.senegalMois;
      senegalMontant = res.senegalMontant;
      senegalPayees = res.senegalPayee;
      senegalImpayees = res.senegalImpayee;
      return res;
    }

  })
    .then((res)=>{
        let optionChart = {
          chart: {
            height: 400,
            type: 'bar',
            stacked: false,
            parentHeightOffset: 0,
            toolbar: {
              show: true,
              zoom: true,
              zoomin: true,
              zoomout: true,
            },

          },
          plotOptions: {
            bar: {
              columnWidth: '35%',
              dataLabels: {
                position: 'top'
              }

            }
          },
          dataLabels: {
            enabled: false
          },
          legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'start',
            labels: {
              colors: legendColor,
              useSeriesColors: true
            }
          },
          colors: [chartColors.column.series1, chartColors.column.series2, chartColors.column.series3],
          stroke: {
            show: true,
            colors: ['transparent']
          },
          grid: {
            borderColor: borderColor,
            xaxis: {
              lines: {
                show: true
              }
            }
          },
          series: [
            {
              name: 'Encours',
              data: res.senegalMontant
            },
            {
              name: 'Payées',
              data: res.senegalPayee
            },
            {
              name: 'Impayées',
              data: res.senegalImpayee
            }
          ],
          xaxis: {
            categories: res.senegalMois,
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
            labels: {
              style: {
                colors: labelColor,
                fontSize: '13px'
              }
            }
          },
          yaxis: {
            labels: {
              style: {
                colors: labelColor,
                fontSize: '13px'
              },
              formatter: function (value) {
                return fm.from(value)+' CFA';
              }
            }
          },
          fill: {
            opacity: 1
          }
        };

        if(paysId === 1){
          barChart.updateOptions( optionChart
            , false,true);
        }
        if(paysId === 2){
          drawChartCote.updateOptions( optionChart
            , false,true);
        }
        if(paysId === 3){
          drawChartGambie.updateOptions( optionChart
            , false,true);
        }
        if(paysId === 4){
          drawChartTogo.updateOptions( optionChart
            , false,true);
        }
        if(paysId === 5){
          drawChartBenin.updateOptions( optionChart
            , false,true);
        }




    });
}

function montantBanque(){
  $.ajax({
    type: 'GET',
    url: `${baseUrl}statistiques/banque/1`,
    success: function(res){

      banqueSenegal.innerHTML = "";



      for(let i= 0; i < res.transaction.length; i++){
        let montant = parseInt(res.transaction[i].total_amount);
        /* let depense = parseInt(res.tab[3]);*/




        let element = '<div class="col-12 col-sm-4">'+
          '<div class="d-flex gap-2 align-items-center">'+
          '<div class="badge rounded bg-label-primary p-1"><img  height="40" class=" rounded" src="'+res.transaction[i].banque.image_url+'" alt=""></div>'+
          '<h6 class="mb-0">'+res.transaction[i].banque.nom+'</h6>'+
          '</div>'+
          '<h4 class="my-2 pt-1">'+fm.from(montant - res.dep[i])+' CFA </h4>'+
          '</div>';
        banqueSenegal.innerHTML += element ;
      }


    }
  }) ;
}

