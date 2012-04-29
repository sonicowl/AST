//Get Book Data
currentTitle = "1 - THE BREEZE";
var bookData = {
  getComponents: function () {
    return [
      'part_01', 
 'part_02',
 'part_03', 
 'part_04', 
 'part_05',
 'part_06',
 'part_07', 
 'part_08',
 'part_09',
 'part_10',
 'part_11', 
 'part_12',
 'part_13', 
 'part_14', 
 'part_15',
 'part_16',
 'part_17', 
 'part_18',
 'part_19',
 'part_20',
 'part_21', 
 'part_22',
 'part_23', 
 'part_24', 
 'part_25',
 'part_26',
 'part_27', 
 'part_28',
 'part_29',
 'part_30',
 'part_31', 
 'part_32', 
 'part_33',
 'part_34',
 'part_35', 
 'part_36',
 'part_37'
    ];
  },
  getContents: function () {
    return [
      {
        title: "1 - THE BREEZE",
        src: 'part_01',
chp: '01'
      }
,
{
       title: "2 - PINE COVE",
        src: 'part_02',
chp: '02'
},
{
       title: "3 - TRAVIS",
        src: 'part_03',
chp: '03'
}
,
{
       title: "4 - ROBERT",
        src: 'part_04',
chp: '04'
}
,
{
       title: "5 - AUGUSTUS BRINE",
       src: 'part_05',
chp: '05'
}
,
{
       title: "6 - THE DJINN'S STORY",
       src: 'part_06',
chp: '06'
}
,
{
       title: "7 - ARRIVAL",
       src: 'part_07',
chp: '07'
}
,
{
       title: "8 - ROBERT",
       src: 'part_08',
chp: '08'
}
,
{
       title: "9 - THE HEAD OF THE SLUG",
       src: 'part_09',
chp: '09'
}
,
{
       title: "10 - AUGUSTUS BRINE",
       src: 'part_10',
chp: '10'
}
,
{
       title: "11 - EFFROM",
       src: 'part_11',
chp: '11'
}
,
{
       title: "12 - JENNIFER",
       src: 'part_12',
chp: '12'
}
,
{
       title: "13 - NIGHTFALL",
       src: 'part_13',
chp: '13'
}
,
{
       title: "14 - DINNER",
       src: 'part_14',
chp: '14'
}
,
{
       title: "15 - RACHEL",
       src: 'part_15',
chp: '15'
}
,
{
       title: "16 - HOWARD",
       src: 'part_16',
chp: '16'
}
,
{
       title: "17 - BILLY",
       src: 'part_17',
chp: '17'
}
,
{
       title: "18 - RACHEL",
       src: 'part_18',
chp: '18'
}
,
{
       title: "19 - JENNY'S HOUSE",
       src: 'part_19',
chp: '19'
}
,
{
       title: "20 - EFFROM",
       src: 'part_20',
chp: '20'
}
,
{
       title: "21 - AUGUSTUS BRINE",
       src: 'part_21',
chp: '21'
}
,
{
       title: "22 - TRAVIS AND JENNY",
       src: 'part_22',
chp: '22'
}
,
{
       title: "23 - RIVERA",
       src: 'part_23',
chp: '23'
}
,
{
       title: "24 - AUGUSTUS BRINE",
       src: 'part_24',
chp: '24'
}
,
{
       title: "25 - AMANDA",
       src: 'part_25',
chp: '25'
}
,
{
       title: "26 - TRAVIS'S STORY",
       src: 'part_26',
chp: '26'
}
,
{
       title: "27 - AUGUSTUS",
       src: 'part_27',
chp: '27'
}
,
{
       title: "28 - EFFROM",
       src: 'part_28',
chp: '28'
}
,
{
       title: "29 - RIVERA",
       src: 'part_29',
chp: '29'
}
,
{
       title: "30 - JENNY",
       src: 'part_30',
chp: '30'
}
,
{
       title: "31 - GOOD GUYS",
       src: 'part_31',
chp: '31'
}
,
{
       title: "32 - THE HEAD OF THE SLUG",
       src: 'part_32',
chp: '32'
}
,
{
       title: "33 - RIVERA",
       src: 'part_33',
chp: '33'
}
,
{
       title: "34 - U-PICK-EM",
       src: 'part_34',
chp: '34'
}
,
{
       title: "35 - BAD GUYS, GOOD GUYS",
       src: 'part_35',
chp: '35'
}
,
{
       title: "36 - JENNY, ROBERT, RIVERA, AMANDA, TRAVIS, HOWARD, AND THE SPIDER",
       src: 'part_36',
chp: '36'
}
,
{
       title: "37 - GOOD GUYS",
       src: 'part_37',
chp: '37'
}

    ]
  },
  getComponent: function (cmptId) {
    return { nodes: [document.getElementById(cmptId).cloneNode(true)] };
  },
  getMetaData: function(key) {
    return {
      title: "Practical Demonkeeping",
      creator: "Sonic Owl"
    }[key];
  }
}