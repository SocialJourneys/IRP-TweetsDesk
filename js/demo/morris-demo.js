$(function() {

    Morris.Area({
        element: 'morris-hour-chart',
        data: [{
            hour: '2014-06-10 12:00',
            tweets: 100,
            users: 12,
        }, {
            hour: '2014-06-10 1:00',
            tweets: 200,
            users: 7,
        }, {
            hour: '2014-06-10 2:00',
            tweets: 10,
            users: 3,
        }, {
            hour: '2014-06-10 3:00',
            tweets: 15,
            users: 4,
        }, {
            hour: '2014-06-10 4:00',
            tweets: 5,
            users: 2,
        }, {
            hour: '2014-06-10 5:00',
            tweets: 20,
            users: 5,
        }, {
            hour: '2014-06-10 6:00',
            tweets: 30,
            users: 7,
        }, {
            hour: '2014-06-10 7:00',
            tweets: 100,
            users: 40,
        }, {
            hour: '2014-06-10 8:00',
            tweets: 145,
            users: 70,
        }, {
            hour: '2014-06-10 9:00',
            tweets: 350,
            users: 100,
        },  {
            hour: '2014-06-10 10:00',
            tweets: 100,
            users: 12,
        }, {
            hour: '2014-06-10 11:00',
            tweets: 200,
            users: 7,
        }, {
            hour: '2014-06-10 12:00',
            tweets: 10,
            users: 3,
        }, {
            hour: '2014-06-10 13:00',
            tweets: 15,
            users: 4,
        }, {
            hour: '2014-06-10 14:00',
            tweets: 5,
            users: 2,
        }, {
            hour: '2014-06-10 15:00',
            tweets: 20,
            users: 5,
        }, {
            hour: '2014-06-10 16:00',
            tweets: 30,
            users: 7,
        }, {
            hour: '2014-06-10 17:00',
            tweets: 100,
            users: 40,
        }, {
            hour: '2014-06-10 18:00',
            tweets: 145,
            users: 70,
        }, {
            hour: '2014-06-10 19:00',
            tweets: 350,
            users: 100,
        },
        {
            hour: '2014-06-10 20:00',
            tweets: 20,
            users: 5,
        }, {
            hour: '2014-06-10 21:00',
            tweets: 30,
            users: 7,
        }, {
            hour: '2014-06-10 22:00',
            tweets: 10,
            users: 5,
        }, {
            hour: '2014-06-10 23:00',
            tweets: 33,
            users: 6,
        }, {
            hour: '2014-06-10 24:00',
            tweets: 28,
            users: 6,}
        ],
        xkey: 'hour',
        ykeys: ['tweets', 'users'],
        labels: ['Tweets', 'Users'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

Morris.Area({
        element: 'morris-day-chart',
        data: [{
            day: '2014-05-10',
            tweets: 1000,
            users: 120,
        }, {
            day: '2014-05-11',
            tweets: 2000,
            users: 70,
        }, {
            day: '2014-05-12',
            tweets: 100,
            users: 30,
        }, {
            day: '2014-05-13',
            tweets: 105,
            users: 40,
        }, {
            day: '2014-05-14',
            tweets: 50,
            users: 20,
        }, {
            day: '2014-05-15',
            tweets: 200,
            users: 50,
        }, {
            day: '2014-05-16',
            tweets: 300,
            users: 70,
        }, {
            day: '2014-05-17',
            tweets: 1000,
            users: 400,
        }, {
            day: '2014-05-18',
            tweets: 1405,
            users: 700,
        }, {
            day: '2014-05-18',
            tweets: 3500,
            users: 1000,
        }, {
            day: '2014-05-19',
            tweets: 1000,
            users: 120,
        }, {
            day: '2014-05-20',
            tweets: 2000,
            users: 70,
        }, {
            day: '2014-05-21',
            tweets: 100,
            users: 30,
        }, {
            day: '2014-05-22',
            tweets: 105,
            users: 40,
        }, {
            day: '2014-05-23',
            tweets: 50,
            users: 20,
        }, {
            day: '2014-05-24',
            tweets: 200,
            users: 50,
        }, {
            day: '2014-05-25',
            tweets: 300,
            users: 70,
        }, {
            day: '2014-05-26',
            tweets: 1000,
            users: 400,
        }, {
            day: '2014-05-27',
            tweets: 1405,
            users: 700,
        }, {
            day: '2014-05-28',
            tweets: 3500,
            users: 1000,
        },{
            day: '2014-05-29',
            tweets: 1000,
            users: 120,
        }, {
            day: '2014-05-30',
            tweets: 2000,
            users: 70,
        }, {
            day: '2014-06-01',
            tweets: 100,
            users: 30,
        }, {
            day: '2014-06-02',
            tweets: 105,
            users: 40,
        }, {
            day: '2014-06-03',
            tweets: 50,
            users: 20,
        }, {
            day: '2014-06-04',
            tweets: 2000,
            users: 150,
        }, {
            day: '2014-06-05',
            tweets: 300,
            users: 70,
        }, {
            day: '2014-06-06',
            tweets: 1000,
            users: 400,
        }, {
            day: '2014-06-07',
            tweets: 1405,
            users: 700,
        }, {
            day: '2014-06-08',
            tweets: 3500,
            users: 1000,
        },{
            day: '2014-06-09',
            tweets: 1660,
            users: 550,
        },
          {
            day: '2014-06-10',
            tweets: 1000,
            users: 370,
        }],
        xkey: 'day',
        ykeys: ['tweets', 'users'],
        labels: ['Tweets', 'Users'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

    Morris.Line({
        element: 'morris-line-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
