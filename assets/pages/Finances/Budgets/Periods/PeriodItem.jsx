import React, {useEffect, useState} from "react";

function PeriodItem(props) {
    const [dates, setDates] = useState([]);

    useEffect(() => {
        setDates(getDates(new Date(props.period.startAt), new Date(props.period.endAt)));
    }, []);

    console.log(props.period);

    return (
        <div>
            <div className="table-responsive">
                <table className="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Дата</th>
                        <th scope="col">Обязательные расходы</th>
                        {props.periodCategories.map(category => {
                            return <th key={category.id} scope="col">{category.name}</th>
                        })}
                        <th scope="col">Остаток на день</th>
                        <th scope="col">Фактический остаток</th>
                    </tr>
                    </thead>
                    <tbody>
                    {dates && dates.map(date => {
                        const periodItem = props.periodItems.find((item) => {
                            return new Date(item.date).toDateString() === date.toDateString();
                        });

                        const mandatoryExpense = props.period.expenses.find(item => {
                            return new Date(item.date).toDateString() === date.toDateString();
                        });

                        return (
                            <tr key={date} style={{justifyContent: 'center safe'}}>
                                <th scope="row">{date.toDateString()}</th>
                                <th onClick={() => console.log('pizda')}>{mandatoryExpense?.amount ?? 0} PLN</th>
                                {props.periodCategories.map(category => {
                                    let item = null;

                                    if (periodItem) {
                                        item = periodItem.items.find(item => {
                                            return item.categoryId === category.id;
                                        });
                                    }

                                    return <th key={date+category.id}>{item ? item.amount : 0} PLN</th>;
                                })}
                                <th>0 PLN</th>
                                <th>0 PLN</th>
                            </tr>
                        );
                    })}
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col"/>
                        <th scope="col">Обязательные расходы</th>
                        {props.periodCategories.map(category => {
                            return <th key={category.id} scope="col">{category.name}</th>
                        })}
                        <th scope="col"/>
                        <th scope="col"/>
                    </tr>
                    <tr>
                        <th/>
                        <th>{props.period.expenses?.reduce((partialSum, expense) => partialSum + expense.amount, 0)} PLN</th>
                        {props.periodCategories.map(category => {
                            const sum = props.periodItems.reduce((partialSum, item) => item.items.find(item => item.categoryId === category.id)?.amount + partialSum, 0);

                            return <th key={category.id}>{sum ? sum : 0} PLN</th>
                        })}
                        <th/>
                        <th/>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <ul className="list-group list-group-horizontal" style={{marginTop: '2rem', marginBottom: '3rem'}}>
                <li className="list-group-item" style={{width: '20rem'}}>Всего на месяц</li>
                <li className="list-group-item" style={{width: '20rem'}}>Обязательно на месяц</li>
                <li className="list-group-item" style={{width: '20rem'}}>Остаток на месяц</li>
                <li className="list-group-item" style={{width: '20rem'}}>Сумма на день</li>
                <li className="list-group-item" style={{width: '20rem'}}>Сумма на неделю</li>
            </ul>
        </div>
    );
}

function getDates (startDate, endDate) {
    const dates = []
    let currentDate = startDate
    const addDays = function (days) {
        const date = new Date(this.valueOf())
        date.setDate(date.getDate() + days)
        return date
    }
    while (currentDate <= endDate) {
        dates.push(currentDate)
        currentDate = addDays.call(currentDate, 1)
    }
    return dates
}

export {PeriodItem};